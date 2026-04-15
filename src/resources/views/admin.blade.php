@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/admin.css') }}" />
@endsection

@section('content')
<div class="admin__content">

    <div class="section__title">
        <h2>Admin</h2>
    </div>

    <!-- 検索フォーム -->
    <form class="search__form" action="/search" method="get">
        @csrf
        <div class="search-form__item">
            <input class="search-form__item-input" type="text" name="keyword" placeholder="名前やメールアドレスを入力してください" value="{{ old('keyword') }}">
        </div>
        <div class="search-form__item">
            <select class="search-form__item-select" name="gender">
                <option value="">性別</option>
                <option value="1">男性</option>
                <option value="2">女性</option>
                <option value="3">その他</option>
            </select>
        </div>
        <div class="search-form__item">
            <select class="search-form__item-select" name="category_id">
                <option value="">お問い合わせの種類</option>
                @foreach ($categories as $category)
                <option value="{{ $category->id }}">{{ $category->content }}</option>
                @endforeach
            </select>
        </div>
        <div class="search-form__item">
            <input class="search-form__item-input" type="date" name="date">
        </div>
        <div class="search-form__button">
            <button class="btn__dark  search-form__button-submit" type="submit">検索</button>
        </div>
        <div class="search-form__reset">
            <a class="search-form__reset-link" href="/admin">リセット</a>
        </div>
    </form>

    <!-- ナビ -->
    <div class="admin__nav">
        <a class="export__btn" href="{{ url('/export?' . http_build_query(request()->query())) }}">エクスポート</a>
        <div class="pagination">
            {{ $contacts->links() }}
        </div>
    </div>

    <!-- テーブル -->
    <div class="admin__table">
        <table class="admin-table__inner">
            <tr class="admin-table__row">
                <th class="admin-table__header">お名前</th>
                <th class="admin-table__header">性別</th>
                <th class="admin-table__header">メールアドレス</th>
                <th class="admin-table__header">お問い合わせの種類</th>
                <th class="admin-table__header"></th>
            </tr>
            @foreach ($contacts as $contact)
            <tr class="admin-table__row">
                <td class="admin-table__text">{{ $contact->last_name }}&emsp;{{ $contact->first_name }}</td>
                <td class="admin-table__text">
                    @if($contact->gender == 1) 男性
                    @elseif($contact->gender == 2) 女性
                    @else その他
                    @endif
                </td>
                <td class="admin-table__text">{{ $contact->email }}</td>
                <td class="admin-table__text">{{ $contact->category->content }}</td>
                <td class="admin-table__text">
                    <input type="checkbox" id="modal-toggle-{{ $contact->id }}" class="modal-toggle">
                    <label class="detail__btn" for="modal-toggle-{{ $contact->id }}">詳細</label>

                    <!-- モーダル -->
                    <div class="modal">
                        <label class="modal__overlay" for="modal-toggle-{{ $contact->id }}"></label>
                        <div class="modal__inner">
                            <label class="modal__close-btn" for="modal-toggle-{{ $contact->id }}">×</label>
                            <div class="modal__content">
                                <table class="modal__table">
                                    <tr>
                                        <th>お名前</th>
                                        <td>{{ $contact->last_name }}&emsp;{{ $contact->first_name }}</td>
                                    </tr>
                                    <tr>
                                        <th>性別</th>
                                        <td>
                                            @if($contact->gender == 1) 男性
                                            @elseif($contact->gender ==2) 女性
                                            @else その他
                                            @endif
                                        </td>
                                    </tr>
                                    <tr>
                                        <th>メールアドレス</th>
                                        <td>{{ $contact->email }}</td>
                                    </tr>
                                    <tr>
                                        <th>電話番号</th>
                                        <td>{{ $contact->tel }}</td>
                                    </tr>
                                    <tr>
                                        <th>住所</th>
                                        <td>{{ $contact->address }}</td>
                                    </tr>
                                    <tr>
                                        <th>建物名</th>
                                        <td>{{ $contact->building }}</td>
                                    </tr>
                                    <tr>
                                        <th>お問い合わせの種類</th>
                                        <td>{{ $contact->category->content }}</td>
                                    </tr>
                                    <tr>
                                        <th>お問い合わせ内容</th>
                                        <td>{{ $contact->detail }}</td>
                                    </tr>
                                </table>
                                <form class="delete__form" action="/delete" method="post">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $contact->id }}">
                                    <button class="delete-btn" type="submit">削除</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection