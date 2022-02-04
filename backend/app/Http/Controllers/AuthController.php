<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    #ログインAPI
    /**
     * @OA\Post(
     *  path="/login",
     *  summary="ログイン(事前に認証クッキーを取得すること)",
     *  description="ユーザーが存在するか学校の認証サーバーに問い合わせる。存在する場合ユーザーの登録情報を返す。",
     *  operationId="logIn",
     *  tags={"auth"},
     *  security={{"bearer_token":{}}},
     *  @OA\RequestBody(ref="#/components/requestBodies/post_login_request_body"),
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
     *      response=204,
     *      description="ログインに成功",
     *      @OA\MediaType(mediaType="application/json")
     *  ),
     * )
     */
    public function login(LoginRequest $request)
    {
        $student_number = $request->student_number;
        $password = $request->password;
        $dn = $student_number . config('ldap.ldap_account_suffix');

        $ldap_server = 'ldap://' . config('ldap.ldap_host');
        $ldap_connection = ldap_connect($ldap_server);

        if ($ldap_connection === false) {
            return response()->json('Connection failed', Response::HTTP_INTERNAL_SERVER_ERROR);
        }

        $authenticated = @ldap_bind($ldap_connection, $dn, $password);

        if ($authenticated) {
            ldap_unbind($ldap_connection);

            $login_user = User::where('student_number', '=', $student_number)->first();

            if (is_null($login_user)) {
                $registed_user = new User();
                DB::transaction(function () use ($registed_user, $student_number) {
                    $registed_user->student_number = $student_number;
                    $registed_user->save();
                });

                $login_user = $registed_user;
            }

            Auth::login($login_user);
            $request->session()->regenerate();

            return new UserResource($login_user);
        }

        return response()->json('unauthorized', Response::HTTP_UNAUTHORIZED);
    }

    #ログアウトAPI
    /**
     * @OA\Post(
     *  path="/logout",
     *  summary="ログアウト",
     *  description="ログインユーザーをログアウトする。cookieが削除され、現在のユーザートークンが無効化される。",
     *  operationId="logOut",
     *  tags={"auth"},
     *  security={{"bearer_token":{}}},
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
     *      description="ログアウトに成功",
     *  ),
     * )
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return http_response_code();
    }
}
