<?php

/**
 * @OA\RequestBody(
 *   request="user_regist_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"student_number","user_name"},
 *       @OA\Property(
 *           property="student_number",
 *           type="number",
 *           example="2199999",
 *           description="学籍番号"
 *       ),
 *       @OA\Property(
 *           property="user_name",
 *           type="string",
 *           example="ECC太郎",
 *           description="ユーザーネーム"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="ユーザーのWebサイト",
 *       ),
 *       @OA\Property(
 *           property="self_introduction",
 *           type="string",
 *           example="私はECC太郎です。ITのことなら全部できます。",
 *           description="自己紹介",
 *       ),
 *      @OA\Property(
 *           property="icon",
 *           type="string",
 *           example="backend/public/picture/icon.png",
 *           description="ユーザーのアイコン",
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="user_edit_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"user_name"},
 *       @OA\Property(
 *           property="user_name",
 *           type="string",
 *           example="ECC花子",
 *           description="ユーザーネーム"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="ユーザーのWebサイト",
 *       ),
 *       @OA\Property(
 *           property="self_introduction",
 *           type="string",
 *           example="私はECC花子になりました。やっぱりITできません。",
 *           description="自己紹介",
 *       ),
 *       @OA\Property(
 *           property="icon",
 *           type="string",
 *           example="backend/public/picture/icon.png",
 *           description="ユーザーのアイコン",
 *   ),
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="user_get_single_student_number",
 *   name="student_number",
 *   in="query",
 *   required=true,
 *   example="2199999",
 *   description="学籍番号",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="user_get_offer_list_student_number",
 *   name="student_number",
 *   in="query",
 *   required=true,
 *   example="2199999",
 *   description="対象のユーザーのid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="user_get_promotion_list_student_number",
 *   name="student_number",
 *   in="query",
 *   required=true,
 *   example="2199999",
 *   description="対象のユーザーのid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="user_get_work_list_student_number",
 *   name="student_number",
 *   in="query",
 *   required=true,
 *   example="2199999",
 *   description="対象のユーザーのid",
 * ),
 */
