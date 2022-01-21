<?php

/**
 * @OA\Parameter(
 *   parameter="work_get_single",
 *   name="work_id",
 *   in="query",
 *   required=true,
 *   example="1",
 *   description="作品のid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="work_get_list_tag_ids",
 *   name="work_tag_ids[]",
 *   in="query",
 *   @OA\Schema(
 *        type="array",
 *        @OA\Items(type="number")
 *   ),
 *   description="作品タグのidの配列",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="work_get_list_page",
 *   name="page",
 *   in="query",
 *   description="ページ番号 default 1",
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="post_work_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"title", "work_tag_ids"},
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="百葉箱",
 *           description="作品のタイトル"
 *       ),
 *       @OA\Property(
 *           property="short_description",
 *           type="string",
 *           example="百葉箱",
 *           description="作品の一言"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="詳細~~~~~",
 *           description="作品の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="作品の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="作品の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="work_tag_ids",
 *           type="array",
 * 　　　　　　example="[1,4,6]",
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
 *       required={"work_id", "title", "work_tag_ids"},
 *       @OA\Property(
 *           property="work_id",
 *           type="number",
 *           example="1",
 *           description="作品のid"
 *       ),
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="百葉箱",
 *           description="作品のタイトル"
 *       ),
 *       @OA\Property(
 *           property="short_description",
 *           type="string",
 *           example="百葉箱",
 *           description="作品の一言"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="詳細~~~~~",
 *           description="作品の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="作品の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="作品の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="work_tag_ids",
 *           type="array",
 *           example="[1,4,6]",
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
 *           example="2",
 *           description="作品のid"
 *       ),
 *   ),
 * ),
 */
