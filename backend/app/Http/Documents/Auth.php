<?php
/**
 * @OA\RequestBody(
 *   request="post_login_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"student_number", "password"},
 *       @OA\Property(
 *           property="student_number",
 *           type="string",
 *           example="2180000",
 *           description="学籍番号"
 *       ),
 *       @OA\Property(
 *           property="password",
 *           type="string",
 *           example="******",
 *           description="パスワード"
 *       ),
 *   ),
 * ),
 */
