<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Roles Management') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 relative overflow-x-auto">
                    <div class="flex justify-between mb-4">
                        @if (session('success'))
                            <p
                                x-data="{ show: true }"
                                x-show="show"
                                x-transition
                                x-init="setTimeout(() => show = false, 2000)"
                                class="text-sm text-green-500"
                            >{{ __(session('success')) }}</p>
                        @endif
                        <a href="{{ route('roles.create') }}" class="ml-auto">
                            <x-secondary-button>
                                Create Role
                            </x-secondary-button>
                        </a>
                    </div>
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    Role
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Permissions
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Action
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($roles as $role)
                                <tr class="bg-white">
                                    <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap w-1/6">
                                        {{ $role->name }}
                                    </th>
                                    <td class="px-6 py-4 space-y-2">
                                        @foreach ($role->permissions as $permission)
                                            <span class="bg-green-100 text-green-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm text-nowrap inline-block">
                                                {{ $permission->name }}
                                            </span>
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4 w-1/6 space-x-2">
                                        <a href="{{ route('roles.edit', $role->id) }}">
                                            <i class="bi bi-pencil-fill text-primary"></i>
                                        </a>
                                        <button 
                                        x-data=""
                                        onClick="setDeleteModalActionUrl('role', {{ $role->id }})"
                                        x-on:click.prevent="$dispatch('open-modal', 'confirm-role-deletion')">
                                            <i class="bi bi-trash-fill text-danger"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <x-modal name="confirm-role-deletion" :show="$errors->roleDeletion->isNotEmpty()" focusable>
        <form method="post" class="p-6" id="deleteForm">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this role?') }}
            </h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('Once the role deleted, all of its resources and data will be permanently deleted. Please confirm you would like to permanently delete your this role.') }}
            </p>

            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('Delete Role') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
<script>
    function setDeleteModalActionUrl(resource, id) {
        document.getElementById('deleteForm').action = `/${resource}s/${id}`;
    }
</script>