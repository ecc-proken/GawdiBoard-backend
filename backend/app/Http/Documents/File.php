<?php

/**
 * @OA\RequestBody(
 *   request="file_upload_request_body",
 *   required=true,
 *   @OA\MediaType(
 *       mediaType="multipart/form-data",
 *       @OA\Schema(
 *           @OA\Property(
 *               description="file to upload",
 *               property="file",
 *               type="file",
 *           ),
 *           required={"file"}
 *       )
 *   )
 * ),
 */
