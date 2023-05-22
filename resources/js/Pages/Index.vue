<script setup>
import { Head, Link } from '@inertiajs/vue3';

defineProps({
    canLogin: Boolean,
    canRegister: Boolean,
    laravelVersion: String,
    phpVersion: String,
});
</script>

<template>
    <Head title="Welcome" />

    <body class="bg-gray-900 text-white min-h-screen flex items-center justify-center ">

        <div class="w-full max-w-md mx-auto">
            <div class="bg-gray-800 p-6 rounded shadow-md  ">
                <h1 class="text-center text-3xl mb-4 ">Url Shortener</h1>
                <form action="/shorten" method="POST" class="space-y-6">
                    <div class="border-none">
                        <label for="url" class="sr-only">URL to shorten</label>
                        <input type="url" id="url" name="url" required
                            class="w-full p-3 border appearance-none bg-gray-900 border-gray-900 rounded focus:border-gray-300 focus:ring-0"
                            placeholder="Enter URL to shorten">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class=" p-3 bg-red-600 text-white rounded ">Shorten</button>
                    </div>
                </form>
            </div>
        </div>
    </body>
</template>

<style></style>
