<template>
    <form @submit.prevent="submit">
        <o-field label="Titulo" :variant="error.title ? 'danger' : 'primary'" :message="errors.title">
            <o-input v-model="form.title" value=""></o-input>
        </o-field>
        <o-field label="Description">
            <o-input v-model="form.description" type="textarea" value=""></o-input>
        </o-field>
        <o-field label="Contenido">
            <o-input v-model="form.content" type="textarea" value=""></o-input>
        </o-field>
        <o-field label="Categoria">
            <o-select v-model="form.category_id" placeholder="Seleccione una categoría">
                <option v-for="c in categories" v-bind:key="c.id" :value="c.id">
                    {{ c.title }}
                </option>
            </o-select>
        </o-field>
        <o-field label="Posted">
            <o-select v-model="form.posted" placeholder="Seleccione un estado">
                <option value="yes">Si</option>
                <option value="not">No</option>
            </o-select>
        </o-field>
        <o-button variant="primary" native-type="submit">Enviar</o-button>
    </form>
</template>

<script>
export default {
    data() {
        return {
            categories: [],
            form: {
                title: "",
                description: "",
                content: "",
                category_id: "",
                posted: "",
            },
            errors: {
                title: "",
                description: "",
                content: "",
                category_id: "",
                posted: "",
            },
        };
    },
    mounted() {
        this.getCategory();
    },
    methods: {
        submit() {
            console.log(this.form);
            this.$axios.post("/api/post", 
                this.form
            ).then(res => {
                console.log(res)
            }).catch(error => {
                console.log(error.response.data)

                if(error.response.data.title)
                this.errors.title = error.response.data.title[0]
            })
        },

        getCategory() {
            this.$axios.get("/api/category/all").then((res) => {
                this.categories = res.data;
            });
        },
    },
};
</script>
