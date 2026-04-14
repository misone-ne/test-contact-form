@extends('layouts.app')

@section('content')
<div class="auth__content">
    <div class="section__title">
        <h2>Login</h2>
    </div>
    <form class="auth__form" action="/login" method="post" novalidate>
        @csrf
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
            <button class="btn__dark form__button-submit" type="submit">ログイン</button>
        </div>
    </form>
</div>
@endsection