<template>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="d-block mb-4">
                    <h2>Edit Product</h2>
                </div>
                <div class="shadow rounded bg-white p-4">
                    <div class="row">
                        <div class="panel-group">
                            <div class="panel panel-primary">
                                <div class="panel-heading mb-2">Fill all the information below to register a product.</div>

                                <form class="form-horizontal" action="" method="POST">
                                    <fieldset v-if="step == 1">
                                        <div class="panel-body">
                                            <h4 class="mb-5">Step 1: General Information</h4>
                                            <div class="form-group">
                                                <label for="name" class="mb-0" >Name</label>
                                                <input type="text" class="form-control" id="name" v-model="product.name" name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="category" class="mb-0">Category</label>
                                                <select class="form-control" id="category" v-model="product.category">
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
                                            <div class="form-group">
                                                <label for="description" class="mb-0">Description</label>
                                                <div id="full-wrapper">
                                                    <div id="full-container">
                                                        <vue-editor v-model="product.description" />
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-block text-right">
                                                <button @click.prevent="next()" class="btn btn-primary rounded-button next">
                                                    Next <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>

                                    <fieldset v-if="step == 2">
                                        <div class="panel-body">
                                            <h4 class="mb-5">Step 2: Images</h4>
                                            <div class="form-group">
                                                <input type="file" id="files" class="form-control d-none" name="files" multiple accept="image/*" @change="handleFileUploads($event)">
                                                <button type="button" class="btn btn-light rounded-button" @click="addFiles()">
                                                    Add Images
                                                </button>

                                                <br>

                                                <div class="mt-4 d-inline-block mb-5 p-3" style="border: 5px dashed #EEEEF5; border-radius: 5px; min-width: 25%">
                                                    <div v-for="(file, key) in form.files" :key="key" class="file-listing d-flex justify-content-between align-items-center my-1">
                                                        <div>
                                                            <img :src="thumbnails[key]" width="48px" class="mr-3">
                                                            {{ file.name }}
                                                        </div>
                                                        <span class="remove-file text-danger ml-4" @click="removeFile(key)" style="cursor: pointer" title="Remove">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button @click.prevent="prev()" class="btn btn-light rounded-button previous">
                                                    <i class="fas fa-chevron-left"></i> Previous
                                                </button>
                                                <button @click.prevent="next()" class="btn btn-primary rounded-button next">
                                                    Next <i class="fas fa-chevron-right"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>
                                    <fieldset v-if="step == 3">
                                        <div class="panel-body">
                                            <h4 class="mb-5">Step 3: Additional Information</h4>
                                            <div class="form-group">
                                                <label for="available_at" class="mb-0">Available At</label>
                                                <date-picker v-model="product.available_at" :config="options"></date-picker>
                                            </div>

                                            <div class="d-flex justify-content-between">
                                                <button @click.prevent="prev()" class="btn btn-light rounded-button previous">
                                                    <i class="fas fa-chevron-left"></i> Previous
                                                </button>
                                                <button @click.prevent="submit()" class="btn btn-success rounded-button">
                                                    <i class="fas fa-check"></i> Save
                                                </button>
                                            </div>
                                        </div>
                                    </fieldset>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { VueEditor } from "vue2-editor";

export default {
    props: [
        'id',
    ],
    data() {
        return {
            step: 1,
            thumbnails: [],
            form: {
                files: [],
            },
            product: {},
            options: {
                format: 'YYYY-MM-DD HH:mm:ss',
                sideBySide: true,
                showTodayButton: true,
                showClear: true,
                showClose: true,
                inline: true,
            }
        };
    },
    created() {
        axios.get(route('api.product.show', this.id))
            .then((response) => {
                this.product = response.data;
            });
    },
    methods: {
        prev() {
            this.step--;
        },
        next() {
            this.step++;
        },
        addFiles() {
            $('#files').trigger('click');
        },
        removeFile(key) {
            this.form.files.splice(key, 1);
        },
        handleFileUploads(event) {
            this.thumbnails = []
            let uploadedFiles = event.target.files;

            for (var i = 0; i < uploadedFiles.length; i++) {
                this.form.files.push(uploadedFiles[i]);
                this.thumbnails.push(URL.createObjectURL(uploadedFiles[i]))
            }
        },
        submit() {
            let formData = new FormData()
            formData.append('_method', 'PATCH')
            formData.append('name', this.product.name)
            formData.append('description', this.product.description)
            formData.append('category', this.product.category)
            formData.append('available_at', this.product.available_at)

            for (var i = 0; i < this.form.files.length; i++) {
                let file = this.form.files[i];

                formData.append('files[' + i + ']', file);
            }

            console.log(formData)

            axios.post(route('product.update', this.id), formData,  {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(function(response){
                console.log('Response', response);

                if (response.data.success) {
                    swal.fire({
                        title: 'Success!',
                        html: response.data.message,
                        type: 'success',
                    });

                    setTimeout(function() {
                        window.location.href = route('product.index');
                    }, 1000)
                } else {
                    swal.fire({
                        title: 'Oops!',
                        html: response.data.message,
                        type: 'warning',
                    });
                }
            }).catch(function(error){
                swal.fire({
                    title: 'Error!',
                    html: error,
                    type: 'warning',
                });
            })
        },
    },
};
</script>
