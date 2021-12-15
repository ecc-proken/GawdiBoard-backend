<?php

namespace Database\Factories;

class CommonFactory
{
    public function createClassName()
    {
        $class_name_seed = [
            ['IE', 4, 'ABC'],
            ['SK', 3, 'AB'],
            ['SE', 2, 'A'],
            ['WD', 3, 'A'],
            ['CG', 3, 'A'],
            ['GC', 3, 'A'],
            ['GI', 4, 'AB'],
            ['GN', 4, 'A'],
            ['GO', 3, 'A'],
            ['BN', 2, 'A'],
            ['KE', 2, 'A'],
            ['GJ', 2, 'A'],
            ['GZ', 2, 'A'],
            ['IJ', 2, 'A'],
            ['SZ', 2, 'A'],
            ['ALLIS', 2, 'A'],
            ['HPRO', 1, 'ABCD'],
            ['SGP', 1, 'A'],
        ];

        $index = array_rand($class_name_seed);

        $class_name = $class_name_seed[$index][0] .
            (string) random_int(1, $class_name_seed[$index][1]) .
            substr(str_shuffle($class_name_seed[$index][2]), 0, 1);

        return $class_name;
    }

    public function createJobName()
    {
        $job = [
            '経理、労務',
            'AI・機械学習講師',
            'Webエンジニア',
            'シニアプロダクトマネージャー',
            'プロジェクトマネージャー',
            'タイアップディレクター',
            'Webマーケディング',
            'YouTube動画広告作成担当',
            'オープンポジション',
            'エンジニアリング',
            'コンテンツディレクター',
            '未経験OK・Webデザイナー',
            '在宅バックエンドエンジニア',
            'Androidエンジニア',
            'カナダ支社立ち上げ',
            'サーバーサイドエンジニア',
            'クリエイティブディレクター',
            'YouTubeディレクター',
            'デザイナー、ディレクター',
            'Youtuber',
            'ホスティング ディレクター',
            '商品バイヤー・商品企画営業',
            'ブランディングディレクター',
            'ヘルスケアアプリのPdM',
            'PM・PL候補',
            'タイアップディレクター',
            '仲間募集',
            'ソフトウェア・プロジェクトマー',
            'PM・Webディレクション',
            '動画編集',
            'サイト運営',
            '制作ディレクター',
            'CCO',
            'EC運用ディレクター',
            '在宅 OK 未経験OK',
            'PM候補/BtoB',
            'バイヤー/デザイナー',
            'WEBディレクターサイト制作',
            'PM（プロダクトマネージャー）',
            'プロジェクトマネージャー',
            'アシスタントディレクター',
            'シニアプロダクトマネージャー',
            'プロマネ・業務コンサル',
            'AI・機械学習講師',
            'PdM',
            'PM（AI開発/DS分野）',
            'Vライバーのマネージメント',
            'プロダクション・マネージャー',
            '編集、ライター、ディレクター',
            'コミュニケーションデザイナー',
            'ECサイト運営',
            'インターンシップ',
            'コンテンツプランナー',
            'プロダクトマネージャー',
            'Webディレクター',
            'キャスティングディレクター',
            '未経験歓迎/デザイナー',
            'WEBメディアディレクター',
            '映像クリエイター',
            'アシスタントプロデューサー',
            'プロジェクトマネージャー PM',
            'ディレクター',
            '経理、労務',
            '新卒採用',
            'アウトドア事業のPM',
            '芸能マネージャー',
            '【大阪】ディレクター',
            'グロースハッカー',
            'グループ・家族旅行の魅力づくり',
            'Webデザイン経験者',
            'オープンポジション',
            'WEBディレクターアシスタント',
            'エンタメイベントプロデューサー',
            'プロダクションマネージャー',
            'ゲームプランナー',
            'プロデューサー',
            'プロダクトエンジニア',
            '動画編集＆メディア運営',
            'ECディレクター',
            '新規プロダクト開発PM',
            'オンラインイベント・動画制作',
            '広告・雑誌の制作ディレクター',
            'WEBディレクター',
            'カスタマーサクセスマネージャー',
            'オンライン教材開発',
            '経理・財務担当',
            'プロデューサー/ディレクター',
            '映像プロデューサー',
            'アシスタントWebディレクター',
            '編集ディレクター',
        ];

        $indexs = array_rand($job, random_int(2, 10));
        $text = '';

        foreach ($indexs as $i) {
            $text .= $job[$i] . ': ' . random_int(1, 30) . '人,';
        }

        return $text;
    }

    public function createTargetName()
    {
        $arr = [
            'ALL',
            'IT',
            'WEB',
            'GAME',

        ];

        $class_name_seed = [
            ['IE', 4, 'ABC'],
            ['SK', 3, 'AB'],
            ['SE', 2, 'A'],
        ];

        foreach ($class_name_seed as $temp) {
            for ($i = 1; $i < $temp[1]; $i++) {
                foreach (str_split($temp[2]) as $char) {
                    array_push($arr, $temp[0] . $i . $char);
                }
            }
        }

        $index = array_rand($arr);

        return $arr[$index];
    }
}
