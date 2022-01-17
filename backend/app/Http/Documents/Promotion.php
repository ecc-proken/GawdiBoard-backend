<?php

/**
 * @OA\Parameter(
 *   parameter="promotion_get_single",
 *   name="promotion_id",
 *   in="query",
 *   required=true,
 *   example="2",
 *   description="宣伝のid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="promotion_get_list_tag_ids",
 *   name="offer_tag_ids[]",
 *   in="query",
 *   @OA\Schema(
 *        type="array",
 *        @OA\Items(type="number"),
 *   ),
 *   description="宣伝タグのidの配列",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="promotion_get_list_page",
 *   name="page",
 *   in="query",
 *   description="ページ番号 default 1",
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="post_promotion_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"title", "user_class", "end_date", "promotion_tag_ids"},
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="LT大会",
 *           description="宣伝のタイトル"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="募集詳細~~~~~",
 *           description="宣伝の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="宣伝の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="宣伝の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           example="IE4A",
 *           description="宣伝主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           example="2022-01-31",
 *           description="宣伝の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="promotion_tag_ids",
 *           type="array",
 *           example="[1,4,6]",
 *           description="宣伝タグのidの配列",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="edit_promotion_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"promotion_id", "title", "user_class", "end_date", "promotion_tag_ids"},
 *       @OA\Property(
 *           property="promotion_id",
 *           type="number",
 *           example="1",
 *           description="宣伝のid"
 *       ),
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="LT大会",
 *           description="宣伝のタイトル"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="募集詳細~~~~~",
 *           description="宣伝の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="宣伝の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="宣伝の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           example="IE4A",
 *           description="宣伝主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           example="2022-01-31",
 *           description="宣伝の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="promotion_tag_ids",
 *           type="array",
 *           example="[1,4,6]",
 *           description="宣伝タグのidの配列",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="destroy_promotion_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"promotion_id"},
 *       @OA\Property(
 *           property="promotion_id",
 *           type="number",
 *           example="2",
 *           description="宣伝のid"
 *       ),
 *   ),
 * ),
 */
