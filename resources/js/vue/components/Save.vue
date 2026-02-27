<template>
    <h1 v-if="post && post.id">
        Actualizar Post <span class="font-bold">{{ post.title }}</span>
    </h1>
    <h1 v-else><span>Crear Post</span></h1>

    <form @submit.prevent="submit">
        <div class="grid grid-cols-2 gap-3">
            <div class="col-span-2">
                <o-field label="Titulo" :variant="errors.title ? 'danger' : 'primary'" :message="errors.title">
                    <o-input v-model="form.title"></o-input>
                </o-field>
            </div>

            <o-field :variant="errors.description ? 'danger' : 'primary'" :message="errors.description"
                label="Descripción">
                <o-input v-model="form.description" type="textarea"></o-input>
            </o-field>

            <o-field :variant="errors.content ? 'danger' : 'primary'" :message="errors.content" label="Contenido">
                <o-input v-model="form.content" type="textarea"></o-input>
            </o-field>

            <o-field :variant="errors.category_id ? 'danger' : 'primary'" :message="errors.category_id"
                label="Categoría">
                <o-select v-model="form.category_id" placeholder="Seleccione una categoría">
                    <option v-for="c in categories" :key="c.id" :value="c.id">
                        {{ c.title }}
                    </option>
                </o-select>
            </o-field>

            <o-field :variant="errors.posted ? 'danger' : 'primary'" :message="errors.posted" label="Publicado">
                <o-select v-model="form.posted" placeholder="Seleccione un estado">
                    <option value="yes">Si</option>
                    <option value="not">No</option>
                </o-select>
            </o-field>


            <div class="flex gap-2 items-end" v-if="post">
                <o-field :message="fileError" label="Imagen">
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

            <div class="flex gap-2 items-end" v-if="post">
                <o-field :message="fileError" label="Imagen">
                    <o-upload v-model="filesDaD">
                        <o-section multiple drag-drop variant="primary" tag="a">
                            <o-icon icon="upload"></o-icon>
                            <span>Drag and Drop para cargar archivos</span>
                        </o-section>
                    </o-upload>
                </o-field>

                <span v-for="(file, index) in dropFiles" :key="index">
                    {{ file.name }}
                    <o-button icon-left="times" size="small" native-type="button" @click="deleteDropFile(index)">

                    </o-button>
                </span>

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
            post: null,
            file: null,
            filesDAD: [], // Unificado
            fileError: null,
        };
    },
    watch: {
        // El watcher detecta cuando sueltas archivos en el Drag and Drop
        filesDAD: {
            handler(val) {
                if (val.length > 0) {
                    const lastFile = val[val.length - 1];
                    this.uploadDragAndDrop(lastFile);
                }
            },
            deep: true,
        },
    },
    async mounted() {
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
            const url = !this.post ? "/api/post" : "/api/post/" + this.post.id;
            const method = !this.post ? "post" : "patch";

            this.$axios[method](url, this.form)
                .then(() => this.showSuccess())
                .catch((error) => this.handleErrors(error));
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
            });
        },
        // Subida del botón tradicional
        async upload() {
            const formData = new FormData();
            formData.append("image", this.file);
            this.sendImage(formData);
        },
        // Subida automática del Drag and Drop
        uploadDragAndDrop(fileToUpload) {
            const formData = new FormData();
            formData.append("image", fileToUpload);
            this.sendImage(formData);
        },
        // Función común para enviar imágenes
        sendImage(formData) {
            this.$axios.post("/api/post/upload/" + this.post.id, formData, {
                headers: { "Content-Type": "multipart/form-data" },
            })
            .then((res) => console.log("Subida exitosa", res))
            .catch((error) => {
                this.fileError = error.response.data.message || "Error al subir";
            });
        },
        deleteDropFile(index) {
            this.filesDAD.splice(index, 1);
        },
        async getCategory() {
            const res = await this.$axios.get("/api/category/all");
            this.categories = res.data;
        },
        async getPost() {
            const res = await this.$axios.get("/api/post/slug/" + this.$route.params.slug);
            this.post = res.data;
        },
        initPost() {
            Object.assign(this.form, {
                title: this.post.title,
                description: this.post.description,
                content: this.post.content,
                category_id: this.post.category_id,
                posted: this.post.posted,
            });
        },
    },
};
</script>