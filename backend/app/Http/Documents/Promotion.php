<?php
/**
 * @OA\Parameter(
 *   parameter="promotion_get_single",
 *   name="promotion_id",
 *   in="query",
 *   required=true,
 *   description="宣伝のid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="promotion_get_list_tag_ids",
 *   name="offer_tag_ids[]",
 *   in="query",
 *   required=true,
 *   @OA\Schema(
 *        type="array",
 *        @OA\Items(type="integer")
 *   ),
 *   description="宣伝タグのidの配列",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="promotion_get_list_page",
 *   name="page",
 *   in="query",
 *   required=true,
 *   description="ページ番号 default 1",
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="post_promotion_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"title", "user_class", "end_date"},
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           description="宣伝のタイトル"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           description="宣伝の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           description="宣伝の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           description="宣伝の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           description="宣伝主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           description="宣伝の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="promotion_tag_ids",
 *           type="array",
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
 *       required={"promotion_id"},
 *       @OA\Property(
 *           property="promotion_id",
 *           type="number",
 *           description="宣伝のid"
 *       ),
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           description="宣伝のタイトル"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           description="宣伝の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           description="宣伝の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           description="宣伝の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           description="宣伝主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           description="宣伝の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="promotion_tag_ids",
 *           type="array",
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
 *           description="宣伝のid"
 *       ),
 *   ),
 * ),
 */
