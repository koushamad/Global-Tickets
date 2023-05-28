<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <div class="fixed inset-0"/>
            <div class="fixed inset-0 overflow-hidden">
                <div class="absolute inset-0 overflow-hidden">
                    <div class="pointer-events-none fixed inset-y-0 right-0 flex max-w-full pl-10 sm:pl-16">
                        <TransitionChild as="template"
                                         enter="transform transition ease-in-out duration-500 sm:duration-700"
                                         enter-from="translate-x-full" enter-to="translate-x-0"
                                         leave="transform transition ease-in-out duration-500 sm:duration-700"
                                         leave-from="translate-x-0" leave-to="translate-x-full">
                            <DialogPanel class="pointer-events-auto w-screen max-w-2xl">
                                <form>
                                    <div class="flex h-full flex-col overflow-y-scroll bg-white py-6 shadow-xl">
                                        <div class="px-4 sm:px-6">
                                            <div class="flex items-start justify-between">
                                                <DialogTitle class="text-base font-semibold leading-6 text-gray-900">
                                                    Short Link Create or Update
                                                </DialogTitle>
                                                <div class="ml-3 flex h-7 items-center">
                                                    <button type="button"
                                                            class="rounded-md bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                                                            @click="open = false">
                                                        <span class="sr-only">Short Link</span>
                                                        <XMarkIcon class="h-6 w-6" aria-hidden="true"/>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6" v-show="hasError">
                                            <div class="rounded-md bg-red-50 p-4">
                                                <div class="flex">
                                                    <div class="flex-shrink-0">
                                                        <XCircleIcon class="h-5 w-5 text-red-400" aria-hidden="true"/>
                                                    </div>
                                                    <div class="ml-3">
                                                        <div class="mt-2 text-sm text-red-700">
                                                            <ul v-for="error in errors" role="list"
                                                                class="list-disc space-y-1 pl-5">
                                                                <li>{{ error }}</li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                            <div>
                                                <label for="email"
                                                       class="block text-sm font-medium leading-6 text-gray-900">Url</label>
                                                <div class="mt-2">
                                                    <input type="url" name="url" id="url"
                                                           v-model="shortLink.url"
                                                           class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"
                                                           placeholder="http://example.com"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="relative mt-6 flex-1 px-4 sm:px-6">
                                            <button type="button"
                                                    @click="submitShortLink"
                                                    class="rounded-md bg-indigo-50 px-3 py-2 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100">
                                                Submit
                                            </button>
                                            <button type="button"
                                                    v-show="isUpdate"
                                                    @click="deleteShortLink"
                                                    class="rounded-md bg-red-50 px-3 py-2 text-sm font-semibold text-indigo-600 shadow-sm hover:bg-indigo-100">
                                                Delete
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </DialogPanel>
                        </TransitionChild>
                    </div>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="sm:flex sm:items-center">
            <div class="sm:flex-auto">
                <h1 class="text-base font-semibold leading-6 text-gray-900">Short Links</h1>
                <p class="mt-2 text-sm text-gray-700">A list of all the user short links</p>
            </div>
            <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                <button type="button"
                        @click="createShortLink"
                        class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    Add short link
                </button>
            </div>
        </div>
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Url</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Short
                                Link
                            </th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Clicks
                            </th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        <tr v-for="shortLink in shortLinks" :key="shortLink.id">
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ shortLink.url }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{
                                    shortLink.short_link_url
                                }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ shortLink.clicks }}</td>
                            <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a href="#" class="text-indigo-600 hover:text-indigo-900"
                                   @click="updateShortLink(shortLink.id)"
                                >Edit<span class="sr-only">, {{ shortLink.id }}</span></a
                                >
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>

import {ref, onMounted} from 'vue';
import axios from '@/Config/axios';
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from '@headlessui/vue'
import {XMarkIcon} from '@heroicons/vue/24/outline'
import {XCircleIcon} from '@heroicons/vue/20/solid'


const open = ref(false)
const shortLinks = ref([]);
const errors = ref([]);
const shortLink = ref({});
const hasError = ref(false);
const isUpdate = ref(false);
const createShortLink = () => {
    open.value = true;
    errors.value = [];
    hasError.value = false;
    isUpdate.value = false;
    shortLink.value = {
        id: '',
        url: '',
        clicks: 0,
        short_link_url: '',
    };
}
const updateShortLink = async (id) => {
    errors.value = [];
    hasError.value = false;
    isUpdate.value = true;
    const response = await axios.get('/short-links/' + id);
    shortLink.value = response.data.data;
    open.value = true;
}

const submitShortLink = async () => {
    if (isUpdate.value) {
        const res = await axios.put('/short-links/' + shortLink.value.id, shortLink.value).catch(error => {
            errors.value = error.response.data.errors;
            hasError.value = true;
        }).then((res) => {
            if (res) {
                hasError.value = false;
            }
        });
    } else {
        const res = await axios.post('/short-links', shortLink.value).catch(error => {
            errors.value = error.response.data.errors;
            hasError.value = true;
        }).then((res) => {
            if (res) {
                hasError.value = false;
            }
        });
    }

    if (!hasError.value) {
        await getShortLinks();
        shortLink.value = {
            id: '',
            url: '',
            clicks: 0,
            short_link_url: '',
        };
        open.value = false;
        hasError.value = false;
    }
}

const deleteShortLink = async () => {
    const res = await axios.delete('/short-links/' + shortLink.value.id).catch(error => {
        console.log(error.response);
        errors.value = error.response.data.errors;
        hasError.value = true;
    })

    if (res) {
        await getShortLinks();
        shortLink.value = {
            id: '',
            url: '',
            clicks: 0,
            short_link_url: '',
        };
        open.value = false;
        hasError.value = false;
    }
}

const getShortLinks = async () => {
    const response = await axios.get('/user');
    shortLinks.value = await response.data.data.short_links;
}

onMounted(() => {
    getShortLinks();
});

</script>
