<form method="post" name="form{{ $catalog_id }}" action="/mypage/original_catalog/detail" class="oc_card">
    @csrf
    <input type="hidden" name="id" value="{{ $catalog_id }}">
    <a href="javascript:form{{ $catalog_id }}.submit()">
        <img src="{{ asset( 'image/catalog_imgs/'.sprintf('%05d', $img_id).'.png',true)}}" alt="{{ $name }}さんへのギフトカタログのイメージ画像" class="oc_img">
        <div class="oc_detail">
            <h3>{{ $name }}さんへの<br>オリジナルギフトカタログ</h3>
        </div>
    </a>
</form>
