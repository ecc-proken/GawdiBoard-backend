<?php

/**
 * @OA\RequestBody(
 *   request="contact_request_body",
 *   required=true,
 *   @OA\JsonContent(
 *       required={"contact_type","content"},
 *       @OA\Property(
 *           property="contact_type",
 *           type="string",
 *           description="お問い合わせの種類"
 *       ),
 *       @OA\Property(
 *           property="content",
 *           type="string",
 *           description="お問い合わせの内容",
 *       ),
 *   ),
 * ),
 */
