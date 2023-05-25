<script setup>
import { Head, Link } from '@inertiajs/vue3';
import { router } from '@inertiajs/vue3'
import { reactive } from 'vue'
import { ref, computed } from 'vue';
import { useForm } from '@inertiajs/vue3'


// Create a ref with nullable string type
const fullUrl = ref("");
const shortenedUrl = ref("");
const copyStatus = ref('Copy');

const details = computed(() => {

    if (!fullUrl) return '';
    const reduction = fullUrl.value.length - shortenedUrl.value.length;
    return `URL reduced by ${reduction} characters`;

});



const copyShortenedUrl = () => {
    if (!shortenedUrl.value) return;

    navigator.clipboard.writeText(shortenedUrl.value).then(() => {
        copyStatus.value = 'Copied!';
        setTimeout(() => { copyStatus.value = 'Copy'; }, 2000); // Reset after 2 seconds
    }).catch((error) => {
        console.error('Failed to copy shortened URL: ', error);
        copyStatus.value = 'Failed to copy';
    });
};
const buttonClass = computed(() => {
    return copyStatus.value === 'Copied!' ? 'bg-indigo-600' : 'bg-red-600';
});

function submit() {
    const config = {
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    };
    axios.post(route("shortner.store"), { full: fullUrl.value }, config)
        .then(response => {
            // Handle the response data
            shortenedUrl.value = response.data.short;
        })
        .catch(error => {
            // Handle any errors that occur during the request
            console.error('Error:', error);
        });

}
</script>

<template>
    <Head title="Welcome" />

    <body class="bg-gray-900 text-white min-h-screen flex items-center justify-center ">

        <div class="w-full max-w-md mx-auto">
            <div class="bg-gray-800 p-6 rounded shadow-md  ">
                <h1 class="text-center text-3xl mb-4 ">Url Shortener</h1>
                <form @submit.prevent="submit" action="/shorten" method="POST" class="space-y-6">
                    <div class="border-none">
                        <label for="url" class="sr-only">URL to shorten</label>
                        <input type="url" name="fullUrl" id="url" v-model="fullUrl" required
                            class="w-full p-3 border appearance-none bg-gray-900 border-gray-900 rounded focus:border-gray-300 focus:ring-0"
                            placeholder="Enter URL to shorten">
                    </div>
                    <div class="flex justify-center">
                        <button type="submit" class=" p-3 bg-red-600 text-white rounded ">Shorten</button>
                    </div>
                </form>
            </div>
            <div v-if="shortenedUrl" class="bg-gray-800 mt-6 p-6 rounded shadow-md">
                <h2 class="text-center text-2xl mb-4 ">Your Shortened URL</h2>
                <div class=" mb-4 flex items-center justify-between bg-gray-700 p-2 rounded">
                    <div class="text-white truncate">
                        {{ shortenedUrl }}
                    </div>
                    <button type="button" @click="copyShortenedUrl()"
                        :class="[buttonClass, 'text-white rounded p-2']">{{ copyStatus }}</button>
                </div>
                <div class="text-white">
                    {{ details }}
                </div>
            </div>

        </div>
    </body>
</template>

<style></style>
