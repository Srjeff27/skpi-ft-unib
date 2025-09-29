<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-black leading-tight">Notifikasi</h2>
    </x-slot>

    <div class="pt-8 pb-16">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 space-y-4">
            <form method="POST" action="{{ route('student.notifications.read_all') }}">
                @csrf
                <button class="px-3 py-1.5 rounded-md bg-[#1b3985] text-white text-sm">Tandai semua sudah dibaca</button>
            </form>

            <div class="bg-white rounded-lg shadow-sm divide-y">
                @forelse($notifications as $n)
                    @php $data = $n->data; @endphp
                    <div class="p-4 {{ is_null($n->read_at) ? 'bg-orange-50' : '' }}">
                        <div class="flex items-center justify-between">
                            <div class="font-medium">{{ $data['title'] ?? 'Notifikasi' }}</div>
                            <div class="text-xs text-gray-500">{{ optional($n->created_at)->diffForHumans() }}</div>
                        </div>
                        @if(!empty($data['judul_kegiatan']))
                            <div class="text-gray-700">{{ $data['judul_kegiatan'] }}</div>
                        @endif
                        @if(!empty($data['message']))
                            <div class="text-xs text-gray-500">{{ $data['message'] }}</div>
                        @endif
                        <div class="mt-2 flex gap-2">
                            @if(is_null($n->read_at))
                                <form method="POST" action="{{ route('student.notifications.read', $n->id) }}">
                                    @csrf
                                    <button class="text-xs text-[#1b3985] underline">Tandai dibaca</button>
                                </form>
                            @else
                                <form method="POST" action="{{ route('student.notifications.unread', $n->id) }}">
                                    @csrf
                                    <button class="text-xs text-[#1b3985] underline">Tandai belum dibaca</button>
                                </form>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">Belum ada notifikasi.</div>
                @endforelse
            </div>

            <div>
                {{ $notifications->links() }}
            </div>
        </div>
    </div>
</x-app-layout>

