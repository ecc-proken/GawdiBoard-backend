<?php

use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in([
        __DIR__ . '/app',
        __DIR__ . '/config',
        __DIR__ . '/database',
        __DIR__ . '/resources',
        __DIR__ . '/routes',
        __DIR__ . '/tests',
    ])
    ->name('*.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);


$config = new PhpCsFixer\Config();
return $config->setRules([
        '@PSR2' => true,
        'align_multiline_comment' => ['comment_type'=>'phpdocs_like'],
        'array_indentation' => true,
        'array_syntax' => true,
        'binary_operator_spaces' => true,
        'blank_line_before_statement' => ['statements'=>['return']],
        'cast_spaces' => true,
        'class_attributes_separation' => ['elements'=>['const'=>'only_if_meta','method'=>'one','property'=>'only_if_meta','trait_import'=>'none']],
        'clean_namespace' => true,
        'empty_loop_condition' => true,
        'explicit_indirect_variable' => true,
        'explicit_string_variable' => true,
        'fully_qualified_strict_types' => true,
        'function_typehint_space' => true,
        'include' => true,
        'lambda_not_used_import' => true,
        'linebreak_after_opening_tag' => true,
        'magic_constant_casing' => true,
        'magic_method_casing' => true,
        'method_chaining_indentation' => true,
        'native_function_casing' => true,
        'native_function_type_declaration_casing' => true,
        'no_alias_language_construct_call' => true,
        'no_alternative_syntax' => true,
        'no_empty_statement' => true,
        'no_extra_blank_lines' => true,
        'no_leading_namespace_whitespace' => true,
        'no_singleline_whitespace_before_semicolons' => true,
        'no_spaces_around_offset' => true,
        'no_trailing_comma_in_list_call' => true,
        'no_unneeded_curly_braces' => true,
        'no_unused_imports' => true,
        'no_whitespace_before_comma_in_array' => true,
        'no_whitespace_in_blank_line' => true,
        'normalize_index_brace' => true,
        'object_operator_without_whitespace' => true,
        'single_quote' => true,
        'single_space_after_construct' => true,
        'standardize_not_equals' => true,
        'trailing_comma_in_multiline' => true,
        'trim_array_spaces' => true,
        'types_spaces' => true,
        'unary_operator_spaces' => true,
        'whitespace_after_comma_in_array' => true,
    ])
    ->setUsingCache(false)
    ->setFinder($finder);