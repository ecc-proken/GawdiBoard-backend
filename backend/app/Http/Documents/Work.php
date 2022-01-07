<?php
/**
 * @OA\Parameter(
 *   parameter="work_get_single",
 *   name="work_id",
 *   in="query",
 *   required=true,
 *   description="作品のid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="work_get_list_tag_ids",
 *   name="work_tag_ids[]",
 *   in="query",
 *   required=true,
 *   @OA\Schema(
 *        type="array",
 *        @OA\Items(type="integer")
 *   ),
 *   description="作品タグのidの配列",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="work_get_list_page",
 *   name="page",
 *   in="query",
 *   required=true,
 *   description="ページ番号 default 1",
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="post_work_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"title"},
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           description="作品のタイトル"
 *       ),
 *       @OA\Property(
 *           property="short_description",
 *           type="string",
 *           description="作品の一言"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           description="作品の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           description="作品の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           description="作品の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="work_tag_ids",
 *           type="array",
 *           description="作品タグのidの配列",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="edit_work_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"work_id"},
 *       @OA\Property(
 *           property="work_id",
 *           type="number",
 *           description="作品のid"
 *       ),
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           description="作品のタイトル"
 *       ),
 *       @OA\Property(
 *           property="short_description",
 *           type="string",
 *           description="作品の一言"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           description="作品の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           description="作品の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           description="作品の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="work_tag_ids",
 *           type="array",
 *           description="作品タグのidの配列",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="destroy_work_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"work_id"},
 *       @OA\Property(
 *           property="work_id",
 *           type="number",
 *           description="作品のid"
 *       ),
 *   ),
 * ),
 */
