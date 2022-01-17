<?php

/**
 * @OA\Parameter(
 *   parameter="offer_get_single",
 *   name="offer_id",
 *   in="query",
 *   required=true,
 *   example="1",
 *   description="募集のid",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="offer_get_list_tag_ids",
 *   name="offer_tag_ids[]",
 *   in="query",
 *   @OA\Schema(
 *        type="array",
 *        @OA\Items(type="integer")
 *   ),
 *   description="募集タグのidの配列",
 * ),
 */

/**
 * @OA\Parameter(
 *   parameter="offer_get_list_page",
 *   name="page",
 *   in="query",
 *   description="ページ番号 default 1",
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="post_offer_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"title", "user_class", "end_date", "offer_tag_ids"},
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="卒業制作メンバー募集",
 *           description="募集のタイトル"
 *       ),
 *       @OA\Property(
 *           property="target",
 *           type="string",
 *           example="IE4A",
 *           description="募集の対象者"
 *       ),
 *       @OA\Property(
 *           property="job",
 *           type="string",
 *           example="lalavel書ける人 : 1人、デザインできる人：1人",
 *           description="役職ごとの募集人数"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="募集詳細~~~~~",
 *           description="募集の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="募集の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="募集の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           example="IE4A",
 *           description="募集主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           example="2022-01-31",
 *           description="募集の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="offer_tag_ids",
 *           type="array",
 *           example="[1,4,6]",
 *           description="募集タグのidの配列",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="edit_offer_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"offer_id", "title", "user_class", "end_date", "offer_tag_ids"},
 *       @OA\Property(
 *           property="offer_id",
 *           type="number",
 *           example="2",
 *           description="募集のid"
 *       ),
 *       @OA\Property(
 *           property="title",
 *           type="string",
 *           example="卒業制作メンバー募集",
 *           description="募集のタイトル"
 *       ),
 *       @OA\Property(
 *           property="target",
 *           type="string",
 *           example="IE4A",
 *           description="募集の対象者"
 *       ),
 *       @OA\Property(
 *           property="job",
 *           type="string",
 *           example="lalavel書ける人 : 2人、デザインできる人：1人",
 *           description="役職ごとの募集人数"
 *       ),
 *       @OA\Property(
 *           property="note",
 *           type="string",
 *           example="募集詳細~~~~~",
 *           description="募集の備考"
 *       ),
 *       @OA\Property(
 *           property="picture",
 *           type="string",
 *           example="https://example.com",
 *           description="募集の画像"
 *       ),
 *       @OA\Property(
 *           property="link",
 *           type="string",
 *           example="https://example.com",
 *           description="募集の参考サイト"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           example="IE4A",
 *           description="募集主のクラス"
 *       ),
 *       @OA\Property(
 *           property="end_date",
 *           type="date",
 *           example="2022-01-31",
 *           description="募集の掲載終了日"
 *       ),
 *       @OA\Property(
 *           property="offer_tag_ids",
 *           type="array",
 *           description="募集タグのidの配列",
 *           example="[1,4,6]",
 *           @OA\Items(
 *               type="number",
 *           ),
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="destroy_offer_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"offer_id"},
 *       @OA\Property(
 *           property="offer_id",
 *           type="number",
 *           example="2",
 *           description="募集のid"
 *       ),
 *   ),
 * ),
 */

/**
 * @OA\RequestBody(
 *   request="apply_offer_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"offer_id","interest","user_class","message"},
 *       @OA\Property(
 *           property="offer_id",
 *           type="number",
 *           example="4",
 *           description="募集のid"
 *       ),
 *       @OA\Property(
 *           property="interest",
 *           type="number",
 *           example="2",
 *           description="応募者の興味度 (1:高い 2:並 3:低)"
 *       ),
 *       @OA\Property(
 *           property="user_class",
 *           type="string",
 *           example="IE3A",
 *           description="募集主のクラス"
 *       ),
 *       @OA\Property(
 *           property="message",
 *           type="string",
 *           example="laravel使えるのであれば参加したいです。",
 *           description="メッセージ"
 *       ),
 *   ),
 * ),
 */
