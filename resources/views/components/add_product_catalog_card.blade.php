<form method="post" name="form{{ $catalog_id }}" action="/mypage/original_catalog/add_process" class="oc_card">
    @csrf
    <input type="hidden" name="id" value="{{ $catalog_id }}">
    <a href="javascript:form{{ $catalog_id }}.submit()">
        <img src="/image/catalog_imgs/{{ sprintf('%05d', $img_id) }}.png" alt="{{ $name }}さんへのギフトカタログのイメージ画像" class="oc_img">
        <div class="oc_detail">
            <h3>{{ $name }}さんへの<br>ギフトカタログ</h3>
        </div>
    </a>
</form>
