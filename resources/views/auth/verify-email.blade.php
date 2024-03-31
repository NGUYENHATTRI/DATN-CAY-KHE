<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        {{ __('Cảm ơn vì đã đăng ký! Link xác nhận đã được gửi đến email của bạn') }}
    </div>

    @if (session('status') == 'verification-link-sent')
        <div class="mb-4 font-medium text-sm text-green-600">
        {{ __('Link xác nhận đã được gửi đến email bạn đã nhập.') }}
        </div>
    @endif

    <div class="mt-4 flex items-center justify-between">
        <form method="POST" action="{{ route('verification.send') }}">
            @csrf

            <div>
                <x-primary-button>
                {{ __('Gửi lại email') }}
                </x-primary-button>
            </div>
        </form>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit" class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            {{ __('Đăng xuất') }}
            </button>
        </form>
    </div>
</x-guest-layout>
