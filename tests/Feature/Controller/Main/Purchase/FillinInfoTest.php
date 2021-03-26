<?php

namespace Tests\Feature\Controller\Main\Purchase;

use App\Model\Cart;
use App\Model\Lover;
use App\Model\Prefecture;
use App\Model\Product;
use App\Model\Relationship;
use App\Model\Scene;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class FillinInfoTest extends TestCase
{
    use RefreshDatabase;

    public function testCanGet()//アクセスできるかどうか
    {
        $this->seed('BaseSeeder');//戻す

        //ログイン前
        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->get('/purchase/fillin_info');
        $response->assertOk();

        //ログイン後
        $user = factory(User::class)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $response = $this->actingAs($user)
            ->get('/purchase/fillin_info');
        $response->assertOk();
    }

    public function testCanRedirectIfCartIsEmpty()//カートに商品がないときにカート画面にリダイレクトできているか
    {
        $this->seed('BaseSeeder');//戻す

        //ログイン前
        $cookie_str = '';
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->get('/purchase/fillin_info');
        $response->assertRedirect('/cart');

        //ログイン後
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)
            ->get('/purchase/fillin_info');
        $response->assertRedirect('/cart');
    }

    public function testCanShowLovers()//ログイン時、大切な人の一覧が表示されるか
    {
        $this->seed('BaseSeeder');//戻す

        $user = factory(User::class)->create();
        $products = factory(Product::class, 5)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $response = $this->actingAs($user)//大切な人がいない時の表示確認
            ->get('/purchase/fillin_info');
        $response->assertSee('<select id="selected_lover_id" name="selected_lover_id" onchange="submit(this.form)" >'."\n".'                    <option selected value="">いいえ</option>'."\n".'                                    </select>'."\n");

        $lovers = factory(Lover::class, 3)->create([
            'user_id' => $user->id,
        ]);
        $response = $this->actingAs($user)//大切な人がいるとき時の表示確認
            ->get('/purchase/fillin_info');
        $response->assertSee('<select id="selected_lover_id" name="selected_lover_id" onchange="submit(this.form)" >'."\n".'                    <option selected value="">いいえ</option>'."\n".'                                        <option value="'.$lovers[0]->id.'" >'.$lovers[0]->last_name.$lovers[0]->first_name.'</option>'."\n".'                                        <option value="'.$lovers[1]->id.'" >'.$lovers[1]->last_name.$lovers[1]->first_name.'</option>'."\n".'                                        <option value="'.$lovers[2]->id.'" >'.$lovers[2]->last_name.$lovers[2]->first_name.'</option>'."\n".'                                    </select>');
    }

    public function testCanDoNotShowLoverForm()
    {//未ログイン時に大切な人一覧パーツを表示していないか
        $this->seed('BaseSeeder');
        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->get('/purchase/fillin_info');
        $response->assertOk()
            ->assertDontSee('<select id="selected_lover_id"');
    }

    public function testCanShowSelectedLoverInfo()//選択した大切な人の情報がフォームに反映されるか
    {
        $this->seed('BaseSeeder');//戻す

        $user = factory(User::class)->create();
        $products = factory(Product::class, 5)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $lover = factory(Lover::class)->create([
            'user_id' => $user->id
        ]);
        $currentDate = date('Y/m/d');
        $birthday = $lover->birthday;
        $c = (int)date('Ymd', strtotime($currentDate));
        $b = (int)date('Ymd', strtotime($birthday));
        $age = (int)(($c - $b) / 10000);
        $response = $this->actingAs($user)
            ->withSession(['selected_lover_id' => $lover->id])
            ->get('/purchase/fillin_info');
        $response->assertOk()
            ->assertSee('name="forwarding_last_name"  value="'.$lover->last_name.'"')
            ->assertSee('name="forwarding_first_name"  value="'.$lover->first_name.'"')
            ->assertSee('name="forwarding_last_name_furigana"  value="'.$lover->last_name_furigana.'"')
            ->assertSee('name="forwarding_first_name_furigana"  value="'.$lover->first_name_furigana.'"')
            ->assertSee('name="forwarding_postal_code"  value="'.$lover->postal_code.'"')
            ->assertSee('option value="'.$lover->prefecture_id.'"  selected >'.Prefecture::find($lover->prefecture_id)->name)
            ->assertSee('name="forwarding_address"  value="'.$lover->address.'"')
            ->assertSee('name="forwarding_telephone"  value="'.$lover->telephone.'"')
            ->assertSee('name="age"  value="'.$age.'"')
            ->assertSee('name="gender" value="'.$lover->gender.'" class="radiobtn"  checked="checked" >')
            ->assertSee('value="'.$lover->relationship_id.'" selected >'.Relationship::find($lover->relationship_id)->name)
            ->assertSee('name="lover_id" value="'.$lover->id.'"');
    }

    public function testCanNotGetSelectedLoverInfo()
    {//間違った条件下で大切な人の情報を取得していないか
        $this->seed('BaseSeeder');

        $products = factory(Product::class, 5)->create();
        $cookie_str = '';
        foreach ($products as $product) {
            $cookie_str .= $product->id.',';
        }

        //ログイン×、セッションに値×
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
        //ログイン×、セッションに値○、大切な人の実在×
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession(['selected_lover_id' => -1])
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
        //ログイン×、セッションに値○、大切な人の実在○
        $other_lover = factory(Lover::class)->create();
        $response = $this->withCookies(['cart_product_ids' => $cookie_str])
            ->withSession(['selected_lover_id' => $other_lover->id])
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
        // ログイン○、セッションに値×
        $user = factory(User::class)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }
        $response = $this->actingAs($user)
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
        //ログイン○、セッションに値○、大切な人の実在×
        $response = $this->actingAs($user)
            ->withSession(['selected_lover_id' => -1])
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
        //ログイン○、セッションに値○、大切な人の実在○、自分が登録した大切な人×
        $response = $this->actingAs($user)
            ->withSession(['selected_lover_id' => $other_lover->id])
            ->get('/purchase/fillin_info');
        $response->assertViewHas('selected_lover', null);
    }

    public function testCanUseFillinForm(){//フォームが成立しているか
        $this->seed('BaseSeeder');

        $user = factory(User::class)->create();
        $products = factory(Product::class, 5)->create();
        foreach ($products as $product) {
            factory(Cart::class)->create([
                'user_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }

        $response = $this->actingAs($user)
            ->get('/purchase/fillin_info');
        $response->assertSee('action="/purchase/register_to_session"')
            ->assertSee('li class="input_parts"')
            ->assertSee('button type="submit"');

        $scenes = Scene::get();
        foreach ($scenes as $scene) {
            $response->assertSee($scene->name);
        }

        $relationships = Relationship::get();
        foreach ($relationships as $relationship) {
            $response->assertSee($relationship->name);
        }

        $prefectures = Prefecture::get();
        foreach ($prefectures as $prefecture) {
            $response->assertSee($prefecture->name);
        }
    }
}
