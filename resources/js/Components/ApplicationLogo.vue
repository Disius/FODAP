<script setup>

import {computed} from "vue";

const bgimage = {
    backgroundImage:'url(/storage/img/logo.jpg)',
    backgroundSize: 'cover'
}

</script>
<template>
    <div class="rounded-full mx-auto"
         :style="bgimage">

    </div>
</template>
