<script setup lang="ts">
import { RouterView } from 'vue-router'
import { css } from "../styled-system/css";

</script>

<template>
	<div :class="css({ fontSize: '5xl', fontWeight: 'bold', color:'red' })">Hello 🐼!</div>
	<RouterView />
</template>