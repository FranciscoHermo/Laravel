<template>
    <h1 v-if="post && post.id">
        Actualizar Post <span class="font-bold">{{ post.title }}</span>
    </h1>
    <h1 v-else><span>Crear Post</span></h1>

    <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-3">
            <div class="col-span-2">
                <o-field
                    label="Titulo"
                    :variant="errors.title ? 'danger' : 'primary'"
                    :message="errors.title"
                >
                    <o-input v-model="form.title"></o-input>
                </o-field>
            </div>

            <o-field
                :variant="errors.description ? 'danger' : 'primary'"
                :message="errors.description"
                label="Descripción"
            >
                <o-input v-model="form.description" type="textarea"></o-input>
            </o-field>

            <o-field
                :variant="errors.content ? 'danger' : 'primary'"
                :message="errors.content"
                label="Contenido"
            >
                <o-input v-model="form.content" type="textarea"></o-input>
            </o-field>

            <o-field
                :variant="errors.category_id ? 'danger' : 'primary'"
                :message="errors.category_id"
                label="Categoría"
            >
                <o-select v-model="form.category_id" placeholder="Seleccione una categoría">
                    <option v-for="c in categories" :key="c.id" :value="c.id">
                        {{ c.title }}
                    </option>
                </o-select>
            </o-field>

            <o-field
                :variant="errors.posted ? 'danger' : 'primary'"
                :message="errors.posted"
                label="Publicado"
            >
                <o-select v-model="form.posted" placeholder="Seleccione un estado">
                    <option value="yes">Si</option>
                    <option value="not">No</option>
                </o-select>
            </o-field>

            <div class="flex gap-2 items-end">
                <o-field label="Imagen">
                    <o-upload v-model="file">
                        <o-button variant="primary" tag="a">
                            <o-icon icon="upload"></o-icon>
                            <span>Cargar archivo</span>
                        </o-button>
                    </o-upload>
                </o-field>
                <o-button variant="info" icon-left="upload" @click="upload" :disabled="!file"> 
                    Subir 
                </o-button>
            </div>
        </div>

        <o-button class="mt-4" variant="primary" native-type="submit">Enviar</o-button>
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
            post: null, // Cambiado a null para mejor control
            file: null,
        };
    },
    async mounted() {
        // Cargamos categorías siempre, ya sea crear o editar
        await this.getCategory();

        if (this.$route.params.slug) {
            await this.getPost();
            this.initPost();
        }
    },
    methods: {
        cleanErrorsForm() {
            Object.keys(this.errors).forEach(key => this.errors[key] = "");
        },
        submit() {
            this.cleanErrorsForm();

            if (!this.post) {
                // MODO CREAR
                this.$axios.post("/api/post", this.form)
                    .then(() => this.showSuccess())
                    .catch((error) => this.handleErrors(error));
            } else {
                // MODO ACTUALIZAR
                this.$axios.patch("/api/post/" + this.post.id, this.form)
                    .then(() => this.showSuccess())
                    .catch((error) => this.handleErrors(error));
            }
        },
        handleErrors(error) {
            if (error.response && error.response.data) {
                const serverErrors = error.response.data;
                Object.keys(serverErrors).forEach(key => {
                    this.errors[key] = serverErrors[key][0];
                });
            }
        },
        showSuccess() {
            this.$oruga.notification.open({
                message: "Registro procesado con éxito",
                variant: "success",
                position: "bottom-right",
                duration: 4000,
                closable: true,
            });
        },
        upload() {
            console.log("Archivo a subir:", this.file);
        },
        async getCategory() {
            try {
                const res = await this.$axios.get("/api/category/all");
                this.categories = res.data;
            } catch (e) {
                console.error("Error al cargar categorías", e);
            }
        },
        async getPost() {
            try {
                const res = await this.$axios.get("/api/post/slug/" + this.$route.params.slug);
                this.post = res.data;
            } catch (e) {
                console.error("Error al cargar el post", e);
            }
        },
        initPost() {
            this.form.title = this.post.title;
            this.form.description = this.post.description;
            this.form.content = this.post.content;
            this.form.category_id = this.post.category_id;
            this.form.posted = this.post.posted;
        },
    },
};
</script>