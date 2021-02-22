<form action="/make_result_url" class="search_form" method="get">
    @csrf
    <ul id="inputs" class="inputs">
        <li class="input_parts">
            <label for="target_scene_id">シーン</label>
            <select name="target_scene_id" id="target_scene_id">
                <option value="" selected>選択してください(省略可)</option>
                @foreach ($scenes as $scene)
                    <option value={{$scene->id}} @if(Request('target_scene_id')!=null&&$scene->id==Request('target_scene_id'))selected @endif>{{ $scene->name }}</option>
                @endforeach
            </select>
        </li>
        <li class="input_parts">
            <label for="target_relationship_id">お相手様との関係性</label>
            <select name="target_relationship_id" id="target_relationship_id">
                <option value="" selected>選択してください(省略可)</option>
                @foreach ($relationships as $relationship)
                    <option value={{ $relationship->id }} @if(Request('target_relationship_id')!=null&&$relationship->id==Request('target_relationship_id'))selected @endif>{{ $relationship->name }}</option>
                @endforeach
            </select>
        </li>
        <p id="add_condition"><b>＋もっと詳しい条件で調べる</b></p>
        <div id="option_condition" style="display: none">
            <li class="input_parts">
                <label for="target_genre_id">ジャンル</label>
                <select name="target_genre_id" id="target_genre_id">
                    <option value="" selected>選択してください(省略可)</option>
                    @foreach ($genres as $genre)
                        <option value={{ $genre->id }} @if(Request('target_genre_id')!=null&&$genre->id==Request('target_genre_id'))selected @endif>{{ $genre->name }}</option>
                    @endforeach
                </select>
            </li>
            <li class="input_parts">
                <label for="target_gender">お相手様の性別</label>
                <select name="target_gender" id="target_gender">
                    <option value="" selected>選択してください(省略可)</option>
                    <option value="0" @if(Request('target_gender')!=null&&Request('target_gender')==0)selected @endif>男性</option>
                    <option value="1" @if(Request('target_gender')!=null&&Request('target_gender')==1)selected @endif>女性</option>
                    <option value="2" @if(Request('target_gender')!=null&&Request('target_gender')==2)selected @endif>その他</option>
                </select>
            </li>
            <li class="input_parts">
                <label for="target_generation_id">お相手様の年代</label>
                <select name="target_generation_id" id="target_generation_id">
                    <option value="" selected>選択してください(省略可)</option>
                    @foreach ($generations as $generation)
                        <option value={{ $generation->id }} @if(Request('target_generation_id')!=null&&$generation->id==Request('target_generation_id'))selected @endif>{{ $generation->name }}</option>
                    @endforeach
                </select>
            </li>
        </div>
        <li class="input_parts">
            <label for="sort_by">並べ方</label>
            <select name="sort_by" id="sort_by">
                <option value="0"  @if(Request('sort_by')!=null&&Request('sort_by')==0)selected @endif>関連度の高い順</option>
                <option value="1" @if(Request('sort_by')!=null&&Request('sort_by')==1)selected @endif>人気順</option>
                <option value="2" @if(Request('sort_by')!=null&&Request('sort_by')==2)selected @endif>新着順</option>
            </select>
        </li>
    </ul>
    <input id="search_bar" type="text" class="search_bar" placeholder="検索したいワードを入力" name="keyword" @if(Request('keyword')!=null) value="{{ Request('keyword')}}" @endif  style="display: none">
    <div class="btns">
        <button type="button" id="change_btn" @if(Request('keyword')!=null)class="key_to_conditions_btn"@else class="conditions_to_key_btn" @endif>キーワード検索にする</button>
    </div>
    <div class="btns">
        <button type="submit" class="search_btn">検索</button>
    </div>
</form>
