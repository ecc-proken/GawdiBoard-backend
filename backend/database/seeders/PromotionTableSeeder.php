<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Promotion;

class PromotionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $arr = [
            ['title' => '【ハンズオン】SparkARでARエフェクトを作成してみよう #2', 'note' => 'Meta社(旧Facebook社)が提供するARエフェクトツールであるSparkARの初心者向けハンズオンを開催します。'],
            ['title' => '【登壇】自社開発・受託開発・SESのそれぞれのチェックポイント', 'note' => '未経験からのエンジニア転職をサポートする『転職クエスト』を運営する長岡ゆーきが、今までの活動で得た知見を共有させていただくイベントです。事業形態によってそれぞれ良い点と悪い点があります。自分に合う会社選びの参考になると思いますので、是非ご参加いただければと思います。また講義後には長岡ゆーきに直接質問できる質疑応答の時間もあります！  '],
            ['title' => '未完Study「第2回ウェブ開発のすゝめ〜Reactでモダンなフロントエンド開発をしてみよう！〜', 'note' => '様々な技術に興味がありながらも学業と自分の領域の情報収集から別の技術に発展しにくい、各技術を体型的にどう学んでいいのかわからずに足が止まってしまっている学生エンジニアにむけ、アンバサダーや他講師の専門領域の学び方や一連の開発を学んでいく。それぞれ全4回程度ずつの勉強会を開き、新しい技術に触れる学びの場を作る企画です。'],
            ['title' => '未完Study「第2回メディアアートのすゝめ〜図形を扱ってみよう〜」', 'note' => '様々な技術に興味がありながらも学業と自分の領域の情報収集から別の技術に発展しにくい、各技術を体型的にどう学んでいいのかわからずに足が止まってしまっている学生エンジニアにむけ、アンバサダーや他講師の専門領域の学び方や一連の開発を学んでいく。それぞれ全4回程度ずつの勉強会を開き、新しい技術に触れる学びの場を作る企画です。'],
            ['title' => '絶対に報道されないジョージア事情！コロナ禍でジョージア旅行した人とジョージアに住んでる人が話すよ', 'note' => 'コロナがはじまってもう2年近くが経ちます。「海外留学を断念した」「ワーホリに行きたいけどいつになるか分からない」「海外旅行をずーっと我慢している」というたくさんの方と出会った2021年でした。'],
            ['title' => 'すごい広島446 オンライン', 'note' => '毎週水曜日に開催している「すごい広島」について、昨今の情勢や会場の時短営業に伴い、しばらくはオンライン配信（エア参加オンリー）と致します。 '],
            ['title' => 'エンジニアMeetUp！酪農DXをリードするファームノートの開発とは？', 'note' => '■ファームノートとは？https://farmnote.jp/'],
            ['title' => 'Meta p.s.「多分動くと思うからリリースしようぜ！」', 'note' => 'ここ数年、「フルスタックエンジニア」というワードが独り歩きしています。'],
            ['title' => 'BIM＆BIMスクリプティングもくもく勉強会 #010', 'note' => '建築といっても意匠、構造、設備に施工から維持管理と様々です。BIMといってもRevitやVectorWorksにArchicad、専門分野用など様々です。 それぞれのソフトを使ってより効率的な環境を構築するための機能のカスタマイズに必要な技術も違っています。 それどころか、建築やBIMとはいっても現在はICTやWebアプリケーション、プラットフォームとしてのOSやオープンソース、業務としては建築や不動産、宅建や積算など、必要とされる知識は多岐に渡ります。ですが、それぞれ違うプラットフォームであっても情報を'],
            ['title' => 'BIM＆BIMスクリプティングもくもく勉強会 #009', 'note' => '建築といっても意匠、構造、設備に施工から維持管理と様々です。BIMといってもRevitやVectorWorksにArchicad、専門分野用など様々です。 それぞれのソフトを使ってより効率的な環境を構築するための機能のカスタマイズに必要な技術も違っています。 それどころか、建築やBIMとはいっても現在はICTやWebアプリケーション、プラットフォームとしてのOSやオープンソース、業務としては建築や不動産、宅建や積算など、必要とされる知識は多岐に渡ります。ですが、それぞれ違うプラットフォームであっても情報を'],
            ['title' => 'BIM＆BIMスクリプティングもくもく勉強会 #008', 'note' => '建築といっても意匠、構造、設備に施工から維持管理と様々です。BIMといってもRevitやVectorWorksにArchicad、専門分野用など様々です。 それぞれのソフトを使ってより効率的な環境を構築するための機能のカスタマイズに必要な技術も違っています。 それどころか、建築やBIMとはいっても現在はICTやWebアプリケーション、プラットフォームとしてのOSやオープンソース、業務としては建築や不動産、宅建や積算など、必要とされる知識は多岐に渡ります。ですが、それぞれ違うプラットフォームであっても情報を'],
            ['title' => '自宅仮想環境構築超入門', 'note' => '新人・初心者のインフラエンジニアにとって、自宅サーバー・自宅インフラの構築(遊んでみる)は、初心者からのステップアップに最適です。機器をそろえる「環境整備」の次には「自宅サーバーで何をやるか？」で迷う初心者も多いのでは？そこで、お奨めしたいのが仮想環境の構築。自宅サーバー・自宅インフラのベテラン勢を呼んで「そもそも仮想化とは？」「手軽な仮想環境の作り方」「仮想化環境をクラウドに移行する方法」「仮想環境でコレを試したら仕事で役に立つかも？」といったお話をしていただきます。'],
            ['title' => '仕事を楽にしよう LT会@オンライン', 'note' => '普段の業務や日常の作業を楽にしたことを話すLT会です。'],
            ['title' => '第１回　異種なプログラミング交流会　オフライン', 'note' => '会場は、大阪本町のレンタルスペース会場で開催いたします。今回は、DelphiとTMS WebCoreでフロント、PHPフレームワークYiiでバックエンドを使用するWeb開発の合同勉強会です。'],
            ['title' => '【フリーランス】まだ知らない！？改正直前「電子帳簿保存法改正」対策＆「インボイス制度」おさらい', 'note' => 'フリーランスを取り巻く環境が大きく変わって来ています。'],
            ['title' => '2nd Azure Data and AI Tech Lunch(Online)', 'note' => 'Japan SQL Server User Groupは、Japan SQL Server User Groupは、SQL ServerやAzure Data Platformに関する技術情報をテーマにした勉強会を開催しているコミュニティです。'],
            ['title' => 'JavaScriptでブロックチェーンのプログラミングを書く！オンライン・ハンズオン初級編', 'note' => '11月17日に開催した内容と同じです。初級編に参加した方は、今後開催される中級編に参加できます。事前インストールと動作確認が必要です。初級者優先ですが、Q&Aでは中級者の質問にも回答します。'],
            ['title' => '2021年度 第2回 DBSJセミナー', 'note' => '2019年より安全なデータの利活用をテーマにシリーズ開催してきた日本データベース学会のセミナー、今年も無料・オンラインで開催します！2021年第２回目のセミナーは、AIの倫理をテーマに、中央大学の平野先生よりご講演をいただきます。後半は、実際にAIモデルを構築している企業側から、AI指針やAI開発方法、またモデルの品質管理等ついてご講演していただく予定です。最後に喜連川会長をモデレータとして全講演者とともにパネルディスカッションを実施いたします。'],
            ['title' => '【LT聞きませんか？】技術を語って賞品ゲット！イブにLT会するってどゆこと？', 'note' => '12月24日！平日です！'],
            ['title' => 'シビックテックナイト#35 2021を振り返る＠ヴァーチャルSketch Lab', 'note' => '弊メンバーの@terachan0117 さんが作ってくれたヴァーチャル Sketch Labで、2021年だったのか、2020年だったのかよくわからない今年を振り返りましょう。ライトニングトークも大募集です。ヴァーチャル Sketch Labのスクリーンを使って、ショートプレゼンをしてみませんか？今年、やったこと今年、出来なかったこと来年やってみたいこと・・・などなど、なんでもぶちまけてみましょう（笑)出入りは自由で、もちろん参加費は無料です。'],
        ];

        foreach ($arr as $value) {
            Promotion::factory()->count(1)->create($value);
        }
    }
}
