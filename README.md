<h1>プレゼント専門ECサイト「<a href="https://pleased.sumomo.ne.jp/">Pleased</a>」</h1>
<h2>概要</h2>
誰かにプレゼントをする際に便利なECサイトです。贈り物をするにあたって役に立つ機能をたくさん兼ね備えています。<br>
このサービスは[TechTrainさん](https://techbowl.co.jp/techtrain)で公開されている課題に挑戦した際に制作したものです。<br>
そのため一部は自分のアイデアではなく、課題の中で参考にするように指定されたECサイト様にある機能をそのまま実装した部分もございますのでご了承ください。<br>

<h2>使用した技術</h2>
<ul>
    <li>HTML5</li>
    <li>CSS3</li>
    <li>SCSS</li>
    <li>JavaScript</li>
    <li>Vue.js</li>
    <li>Bootstrap</li>
    <li>PHP7.x</li>
    <li>Laravel6.x</li>
    <li>MySQL</li>
    <li>Stripe.js</li>
</ul>

<h2>機能</h2>
<p>以降、オリジナルで作成した機能の見出しは＊で挟みます。参考元サイト様にある機能(確認できたもの)を実装しただけの部分は無印とします。</p><br>
<h3>会員登録機能</h3>
<p>会員登録が行えます。会員登録をせずともプレゼントの購入は行えますが、会員登録をすると多様な機能が利用できるようになります。</p><br>
<h3>カート機能</h3>
<p>一度に複数購入できるカート機能を実装しています。ログインしている場合はDBでカート内容を保存しています。ログインしていない場合はCookieへカートを用いて内容を保存しています。個数の増減処理はVue.jsで行っています。</p>
<h4>＊自動カート移し替え機能＊</h4>
<p>未ログイン時にカートに入れたものはログインする際に自動でDBで管理するように処理します。</p><br>
<h3>大切な人登録機能</h3>
<p>よくプレゼントを送る大切な人の情報を登録できます。</p>
<h4>＊大切な人へのプレゼント履歴機能＊</h4>
<p>プレゼント購入時に大切な人へのプレゼントであることを設定しておくと、大切な人の専用ページから今までに送ったものの履歴を閲覧できます。</p>
<h4>＊大切な人へのプレゼントレコメンド＊</h4>
<p>大切な人へのプレゼント履歴が一つ以上ある場合、協調フィルタリング方式でその人が好みそうな商品をレコメンドします。</p><br>
<h3>イベントリマインダー機能</h3>
<p>誕生日や記念日など、忘れてはいけない大切な日を登録しておくことができます。イベントの日を過ぎると、一度きりのイベントであった場合、イベント情報は自動で削除されます。毎年繰り返すイベントならば自動で次年度の分のイベント情報を登録します。※イベントを登録するにはお相手を大切な人に登録しておく必要があります。</p>
<h4>＊イベント通知メール＊</h4>
<p>登録したイベントの予定日1ヶ月前になると、メールでお知らせします。メールに添付したリンクを開くと、そのイベントのシーンやイベントのお相手に沿ったプレゼントの検索画面に遷移することができます。</p><br>
<h3>商品購入機能</h3>
<p>カート内に入っている商品を購入できます。決済はStripe.jsのデモ決済で実装しています。</p>
<h4>＊宛先情報オート入力機能＊</h4>
<p>大切な人として登録している人にプレゼントを送る際、お名前と一緒に住所なども登録していれば、宛先情報を自動で入力することができます。</p><br>
<h3>＊オリジナルギフトカタログ機能＊</h3>
<p>サービス内の商品を利用して擬似的なギフトカタログを自分で作れる機能です。</p>
<ol>
    <li>カタログに必要事項を入力し、カタログを登録する</li>
    <li>登録したカタログにお好みの商品を入れていく</li>
    <li>カタログが完成したら送信ボタンで相手にメール送信</li>
    <li>カタログを受け取った相手が商品を選ぶのを待つ</li>
    <li>商品が選ばれたら通知のメールが送られてくるので確認して購入</li>
</ol><br>
<h3>＊ランダムレコメンド機能＊</h3>
<p></p><br>
<h3></h3>
<p></p><br>
<h3></h3>
<p></p><br>
