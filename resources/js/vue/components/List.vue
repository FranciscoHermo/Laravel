<template>
    <div>

        <o-modal v-model:active="confirmDeleteActive">
            <div class="p-4">
                <p>¿Seguro que quieres selecionar el registro seleccionado?</p>
            </div>

            <div class="felx flex-row-reverse gap-2 bg-gray-100 padding">
                <o-button class="" variant="danger">Cancelar</o-button>
                <o-button>Aceptar</o-button>
            </div>


        </o-modal>

        <h1>Listado de Post</h1>
        <o-button size="medium" iconLeft="plus"  @click="$router.push({name: 'save'})" >Crear</o-button>

    <div class="mb-5"></div>
        
        <o-table 
            :loading="isLoading" 
            :data="posts.data || []">
            
            <o-table-column class="table" field="id" label="ID" numeric v-slot="p">
                {{ p.row.id }}
            </o-table-column>
            
            <o-table-column class="table" field="title" label="Titulo" v-slot="p">
                {{ p.row.title }}
            </o-table-column>
            
            <o-table-column class="table" field="posted" label="Posteado" v-slot="p">
                {{ p.row.posted }}
            </o-table-column>
            
            <o-table-column class="table" field="created_at" label="Fecha" v-slot="p">
                {{ p.row.created_at }}
            </o-table-column>
            
            <o-table-column class="table" field="category" label="Categoria" v-slot="p">
                {{ p.row.category?.title || 'Sin categoría' }}
            </o-table-column>
            
            <o-table-column class="table" field="slug" label="Acciones" v-slot="p">
                <router-link class="mr-5" :to="{name:'save', params:{slug: p.row.slug}}">
                    Editar
                </router-link>
                <o-button class="bg-red-700 border" iconLeft="delete" :rounded="true" size="small" variant="danger" @click="deletePost(p)">
                    Eliminar
                </o-button>
            </o-table-column>
        </o-table>
        
        <br>
        
        <o-pagination
            v-if="posts.data && posts.data.length > 0"
            @change="updatePage"
            :total="posts.total"
            v-model:current="currentPage"
            :range-before="2"
            :range-after="2"
            :centered="centered"
            :small="small"
            :simple="false"
            :rounded="true"
            :per-page="posts.per_page"
        />
    </div>
</template>

<script>
export default {
    data() {
        return {
            posts: {  
                data: [],
                total: 0,
                per_page: 10,
                current_page: 1,
                confirmDeleteActive:true,
            },
            isLoading: true,
            currentPage: 1,
            centered: true, 
            small: false    
        }
    },
    
    methods: {
        updatePage() {
            setTimeout(this.listPage, 100);
        },
        
        listPage() {
            this.isLoading = true;
            this.$axios.get(`/api/post?page=${this.currentPage}`)
                .then((res) => {
                    this.posts = res.data;
                    console.log(this.posts);
                })
                .catch((error) => {
                    console.error("Error al cargar página:", error);
                })
                .finally(() => {
                    this.isLoading = false;
                });
        },
        
        deletePost(row) {
            if (confirm('¿Estás seguro de eliminar este post?')) {
                this.isLoading = true;
                
                this.$axios.delete(`/api/post/${row.row.id}`)
                    .then(() => {
                        this.posts.data.splice(row.index, 1);
                        this.posts.total--;
                        
                        console.log('Post eliminado exitosamente');
                    })
                    .catch((error) => {
                        console.error("Error al eliminar post:", error);
                        alert('Error al eliminar el post');
                    })
                    .finally(() => {
                        this.isLoading = false;
                    });
            }
        }
    },
    
    async mounted() {
        try {
            const res = await this.$axios.get('/api/post');
            this.posts = res.data;
            console.log(this.posts);
        } catch (error) {
            console.error("Error al obtener posts:", error);
        } finally {
            this.isLoading = false;
        }
    }
}
</script>