@extends('layouts.app')

@section('content')
<div class="auth__content">
    <div class="section__title">
        <h2>Register</h2>
    </div>
    <form class="auth__form" action="/register" method="post" novalidate>
        @csrf
        <div class="form__group">
            <div class="form__group-title">
                <span class="auth-form__label--item form__label--item">お名前</span>
            </div>
            <div class="form__group-content">
                <input class="auth-form__item-input form__item-input" type="text" name="name" placeholder="例: 山田&#12288;太郎" value="{{ old('name') }}">
                @error('name')
                <div class="form__error">
                    <p>{{ $message }}</p>
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="auth-form__label--item form__label--item">メールアドレス</span>
            </div>
            <div class="form__group-content">
                <input class="auth-form__item-input form__item-input" type="email" name="email" placeholder="例: test@example.com" value="{{ old('email') }}">
                @error('email')
                <div class="form__error">
                    <p>{{ $message }}</p>
                </div>
                @enderror
            </div>
        </div>
        <div class="form__group">
            <div class="form__group-title">
                <span class="auth-form__label--item form__label--item">パスワード</span>
            </div>
            <div class="form__group-content">
                <input class="auth-form__item-input form__item-input" type="password" name="password" placeholder="例: coachtech1106">
                @error('password')
                <div class="form__error">
                    <p>{{ $message }}</p>
                </div>
                @enderror
            </div>
        </div>
        <div class="form__button">
            <button class="btn__dark form__button-submit" type="submit">登録</button>
        </div>
    </form>
</div>
@endsection