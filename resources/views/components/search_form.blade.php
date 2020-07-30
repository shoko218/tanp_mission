<form action="/result" class="search_form" method="get">
    @csrf
    <input type="text" class="search_bar" placeholder="検索したいワードを入力" name="keyword" @if(Request('keyword')!=null))value="{{ Request('keyword') }}" @endif>
    <ul class="inputs">
        <li class="input_parts">
            <label for="target_scene_id">シーン</label>
            <select name="target_scene_id" id="target_scene_id">
                <option value="" selected>選択してください</option>
                @foreach ($scenes as $scene)
                    <option value={{$scene->id}} @if(Request('target_scene_id')!=null&&$scene->id==Request('target_scene_id'))selected @endif>{{ $scene->name }}</option>
                @endforeach
            </select>
        </li>
        <li class="input_parts">
            <label for="target_genre_id">ジャンル</label>
            <select name="target_genre_id" id="target_genre_id">
                <option value="" selected>選択してください</option>
                @foreach ($genres as $genre)
                    <option value={{ $genre->id }} @if(Request('target_genre_id')!=null&&$genre->id==Request('target_genre_id'))selected @endif>{{ $genre->name }}</option>
                @endforeach
            </select>
        </li>
        <li class="input_parts">
            <label for="target_relationship_id">お相手様との関係性</label>
            <select name="target_relationship_id" id="target_relationship_id">
                <option value="" selected>選択してください</option>
                @foreach ($relationships as $relationship)
                    <option value={{ $relationship->id }} @if(Request('target_relationship_id')!=null&&$relationship->id==Request('target_relationship_id'))selected @endif>{{ $relationship->name }}</option>
                @endforeach
            </select>
        </li>
        <li class="input_parts">
            <label for="target_gender">お相手様の性別</label>
            <select name="target_gender" id="target_gender">
                <option value="" selected>選択してください</option>
                <option value="0" @if(Request('target_gender')!=null&&Request('target_gender')==0)selected @endif>男性</option>
                <option value="1" @if(Request('target_gender')!=null&&Request('target_gender')==1)selected @endif>女性</option>
                <option value="2" @if(Request('target_gender')!=null&&Request('target_gender')==2)selected @endif>その他</option>
            </select>
        </li>
        <li class="input_parts">
            <label for="target_generation_id">お相手様の年代</label>
            <select name="target_generation_id" id="target_generation_id">
                <option value="" selected>選択してください</option>
                @foreach ($generations as $generation)
                    <option value={{ $generation->id }} @if(Request('target_generation_id')!=null&&$generation->id==Request('target_generation_id'))selected @endif>{{ $generation->name }}</option>
                @endforeach
            </select>
        </li>
    </ul>
    <div class="btns">
        <button type="submit" class="search_btn">検索</button>
    </div>
</form>
