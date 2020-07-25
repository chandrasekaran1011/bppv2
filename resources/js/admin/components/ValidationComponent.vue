<template>
<div>
    <div v-if="validationErrors">
        <v-alert type="error">
            <li v-for="(value, key, index) in validationErrors" :key="index">{{ value }}</li>
        </v-alert>
    </div>
</div>
</template>

<script>
export default {
    props: ['errors'],
    computed: {
        validationErrors() {
            let errors = Object.values(this.errors);
            errors = errors.flat();
            return errors;
        }
    }
}
</script>
