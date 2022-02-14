<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetTagsRequest;
use App\Http\Requests\StoreFileRequest;
use App\Http\Requests\ContactRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Tag;
use \Symfony\Component\HttpFoundation\Response;
use App\Http\Resources\TagCollection;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Jobs\SendContactManagementEmail;
use App\Jobs\SendInquiryCompletedEmail;
use Illuminate\Http\Request;

class OthersController extends Controller
{
    #タグ一覧
    /**
     * @OA\Get(
     *  path="/api/tag-list",
     *  summary="タグ一覧",
     *  description="登録されているタグの一覧を取得する",
     *  operationId="getTagList",
     *  tags={"tag"},
     *  @OA\Parameter(ref="#/components/parameters/tag_get_list"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="Success",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function tagList(GetTagsRequest $request)
    {
        $fetched_tags = Tag::with([
            'genres',
            'targets',
        ])
            ->where('tag_genre_id', '=', $request->input('tag_genre_id'))
            ->get();

        return new TagCollection($fetched_tags);
    }

    #お問い合わせ送信
    /**
     * @OA\Post(
     *  path="/api/contact",
     *  summary="お問い合わせ送信",
     *  description="お問い合わせの内容を管理者のメールに送信する。お問い合わせの送信者にも確認メールが送信される。",
     *  operationId="contact",
     *  tags={"contact"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/contact_request_body"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     *  @OA\Response(
     *      response=200,
     *      description="お問い合わせが送信された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function contact(ContactRequest $request)
    {
        #送信者の情報
        $sender = Auth::user();
        $sender_email = $sender->email;

        $mail_info = (object) [];
        $mail_info = (object) [
            'student_number' => $sender->student_number,
            'user_name' => $sender->user_name,
            'email' => $sender_email,
            'contact_type' => $request->input('contact_type'),
            'content' => $request->input('content'),
        ];

        #メール送信をキューに格納 (送信先, メール情報)
        SendContactManagementEmail::dispatch($sender_email, $mail_info);
        SendInquiryCompletedEmail::dispatch('Ggwdi-owner@email.com');
    }

    #ファイルアップロード
    /**
     * @OA\Post(
     *  path="/api/file-upload",
     *  summary="ファイルアップロード",
     *  description="画像データをサーバーにアップロードし、保存された画像のurlを返す。",
     *  operationId="fileUpload",
     *  tags={"file"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/file_upload_request_body"),
     *  @OA\Response(
     *      response=401,
     *      description="認証されていない",
     *  ),
     *  @OA\Response(
     *      response=400,
     *      description="クエリパラメータに誤りがある",
     *  ),
     * @OA\Response(
     *      response=403,
     *      description="アクセスが拒否されている",
     *  ),
     * @OA\Response(
     *      response=413,
     *      description="ファイルサイズが制限を超えている",
     *  ),
     * @OA\Response(
     *      response=422,
     *      description="セマンティックエラーにより、処理を実行できなかった",
     *  ),
     * @OA\Response(
     *      response=500,
     *      description="不正なエラー",
     *  ),
     * @OA\Response(
     *      response=504,
     *      description="ゲートウェイやプロキシに問題があり、タイムアウトした",
     * ),
     *  @OA\Response(
     *      response=200,
     *      description="お問い合わせが送信された",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function fileUpload(StoreFileRequest $request)
    {
        $image = Image::make($request->file('file'));
        $resized_image = $image->resize(
            1200,
            null,
            function ($constraint) {
                // 縦横比を保持したままにする
                $constraint->aspectRatio();
            }
        )
            ->encode('jpeg');

        //変更を保存
        $resized_image->save();

        // 画像の名前を一意にするためhash化する。 putFile()の引数にFileクラスを取れないため。
        $hash = md5($resized_image->__toString());
        $path = "images/{$hash}.jpeg";

        //sftpドライバーのディスクに保存 設定は backend/config/filesystems.php
        Storage::disk('sftp')->put($path, $resized_image->__toString());

        return response()->json(
            [
                'path' => $path,
            ],
            Response::HTTP_CREATED
        );
    }
}
