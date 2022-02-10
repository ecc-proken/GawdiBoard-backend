<?php

# sanctumから認証クッキーを取得するドキュメント
/**
 * @OA\Get(
 *  path="/sanctum/csrf-cookie",
 *  summary="認証クッキーを取得する(ログインする前に実行して)",
 *  description="Laravel Sanctumにアクセスして認証クッキーを取得する。chromeの検証ツールからレスポンスヘッダの「X-XSRF-TOKEN」をコピーする。クッキーは暗号化されているので、認証に使用するには平文にする必要がある",
 *  operationId="authCookie",
 *  tags={"auth"},
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
 *      @OA\Header(
 *          header="X-XSRF-TOKEN",
 *          description="Chromeの検証から「Network」-> 「Name」タブの「csrf-cookie」をクリックすると右側にレスポンスヘッダが表示されるので、その中の「XSRF-TOKEN」をコピーする。クッキー文字列の「%3D」は「=」に変更する。",
 *          @OA\Schema( type="string" )
 *      ),
 *      @OA\MediaType(mediaType="application/json")
 *  ),
 * )
 */
