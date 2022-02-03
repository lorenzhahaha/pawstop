<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-block mb-4">
                    <h2>Manage Products</h2>
                </div>
                <div class="shadow rounded bg-white p-4">
                    <div class="row">
                        <div class="col-12 col-xl-3">
                            <div class="form-group">
                                <select class="form-control" id="category" v-model="category" @change="getResults">
                                    <option value="">(Show all categories)</option>
                                    <option value="Working">Working</option>
                                    <option value="Companion">Companion</option>
                                    <option value="Herding">Herding</option>
                                    <option value="Hound">Hound</option>
                                    <option value="Hybrid">Hybrid</option>
                                    <option value="Sporting">Sporting</option>
                                    <option value="Terrier">Terrier</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-3">
                            <div class="form-group">
                                <select class="form-control" id="filter" v-model="filter" @change="getResults">
                                    <option value="">(Select a filter)</option>
                                    <option value="name">Name</option>
                                    <option value="description">Description</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-12 col-xl-3">
                            <div class="form-group">
                                <input type="text" class="form-control" id="keyword" @keyup="getResults" placeholder="Search" v-model="keyword">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-12 text-right">
                            <a :href="createProduct()" class="btn btn-light">
                                <i class="fas fa-plus"></i>
                                <span class="d-none d-sm-inline-block ml-2">Create</span>
                            </a>
                        </div>
                    </div>

                    <div class="row mt-2">
                        <div class="col-12">
                            <table id="product-table" class="table table-hover">
                                <thead>
                                    <tr>
                                        <th scope="col">Name</th>
                                        <th scope="col">Category</th>
                                        <th scope="col">Description</th>
                                        <th scope="col">Available At</th>
                                        <th scope="col">Created By</th>
                                        <th scope="col">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="product in products.data" :key="product.id">
                                        <td>{{ product.name }}</td>
                                        <td>{{ product.category }}</td>
                                        <td v-html="product.description"></td>
                                        <td>{{ product.available_at }}</td>
                                        <td>{{ product.created_by }}</td>
                                        <td>
                                            <a :href="editProduct(product.id)" class="btn btn-warning" title="Edit">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                        </td>
                                    </tr>
                                </tbody>
                                <pagination
                                    :data="products"
                                    @pagination-change-page="getResults"
                                ></pagination>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            products: {},
            category: "",
            filter: "",
            keyword: "",
            fields: ['name', 'description'],
        };
    },
    methods: {
        createProduct() {
            return route('product.create');
        },
        editProduct(id) {
            return route('product.edit', id);
        },
        fetchAllProducts() {
            axios.get(route('api.product.index'))
                .then((data) => (this.products = data.data));
        },
        getResults(page = 1) {
            axios.get(route('api.product.index'), {
                params: {
                    page: page,
                    category: this.category,
                    filter: this.filter,
                    keyword: this.keyword,
                    fields: this.fields,
                }
            })
            .then((response) => {
                this.products = response.data;
            });
        },
    },
    created() {
        this.fetchAllProducts();
    },
};
</script>
