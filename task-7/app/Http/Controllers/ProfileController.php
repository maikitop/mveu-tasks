<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function edit()
    {
        return view('profile.edit');
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        // Валидация
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
        ]);

        // Обновляем основные данные
        $user->name = $request->name;
        $user->email = $request->email;

        // Обработка аватара
        if ($request->hasFile('avatar')) {
            $avatarFile = $request->file('avatar');
            
            // Создаем папку если не существует
            if (!file_exists(public_path('avatars'))) {
                mkdir(public_path('avatars'), 0755, true);
            }

            // Удаляем старый аватар
            if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
                unlink(public_path('avatars/' . $user->avatar));
            }

            // Генерируем уникальное имя
            $avatarName = 'avatar_' . $user->id . '_' . time() . '.' . $avatarFile->getClientOriginalExtension();
            
            // Сохраняем файл напрямую в public/avatars
            $avatarFile->move(public_path('avatars'), $avatarName);
            
            $user->avatar = $avatarName;
        }

        // Сохраняем изменения
        $user->save();

        return redirect()->route('profile.edit')->with('success', 'Профиль обновлен!');
    }

    public function removeAvatar()
    {
        $user = Auth::user();

        if ($user->avatar && file_exists(public_path('avatars/' . $user->avatar))) {
            unlink(public_path('avatars/' . $user->avatar));
            $user->avatar = null;
            $user->save();
        }

        return redirect()->route('profile.edit')->with('success', 'Аватар удален!');
    }
}