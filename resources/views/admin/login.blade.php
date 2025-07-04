<!DOCTYPE html>
<html lang="ja" class="h-full bg-gray-100">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン - 管理画面</title>
    @vite('resources/css/admin.css')
</head>

<body class="flex items-center justify-center h-full">
    <div class="w-full max-w-md p-8 space-y-8 bg-white rounded-lg shadow-md">
        <div>
            @if(isset($logoImg))
                <img class="w-auto h-12 mx-auto" src="{{ asset($logoImg->FILE_PATH . $logoImg->FILE_NAME) }}"
                    alt="COSPLATFORM">
            @endif
            <h2 class="mt-6 text-3xl font-bold text-center text-gray-900">管理画面にログイン</h2>
        </div>
        @if (session('error'))
            <div class="p-4 text-sm text-red-700 bg-red-100 rounded-lg" role="alert">
                {{ session('error') }}
            </div>
        @endif
        <form class="mt-8 space-y-6" action="{{ route('login.access') }}" method="POST">
            @csrf
            <div class="space-y-4 rounded-md shadow-sm">
                <div>
                    <label for="name" class="sr-only">ID</label>
                    <input id="name" name="name" type="text" required
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-t-md focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="ID">
                </div>
                <div>
                    <label for="password" class="sr-only">パスワード</label>
                    <input id="password" name="password" type="password" required
                        class="relative block w-full px-3 py-2 text-gray-900 placeholder-gray-500 border border-gray-300 rounded-none appearance-none rounded-b-md focus:z-10 focus:border-indigo-500 focus:outline-none focus:ring-indigo-500 sm:text-sm"
                        placeholder="パスワード">
                </div>
            </div>
            <div>
                <button type="submit"
                    class="relative flex justify-center w-full px-4 py-2 text-sm font-medium text-white bg-indigo-600 border border-transparent rounded-md group hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                    ログイン
                </button>
            </div>
        </form>
    </div>
</body>

</html>