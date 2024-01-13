
<div class="modal animated zoomIn" id="create-modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-md">
        <div class="modal-content">
            <div class="modal-header">
                <h6 class="modal-title" id="exampleModalLabel">Create Porduct</h6>
            </div>
            <div class="modal-body">
                <form id="save-form">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 p-1">
                                <label class="form-label">Category </label>
                                <select type="text" class="form-control form-select" id="productCategory" >
                                    <option value="">Select Category</option>
                                </select>
                                <label class="form-label">Name</label>
                                <input type="text" class="form-control" id="productNameUpdate">
                                <label class="form-label">Price</label>
                                <input type="text" class="form-control" id="productPriceUpdate">
                                <label class="form-label">Unit</label>
                                <input type="text" class="form-control" id="productUnitUpdate">

                                <br/>
                                <img class="w-15" id="oldImg" src="{{asset('images/default.jpg')}}" >
                                <br/>

                                <label class="form-label">Image</label>
                                <input oninput="oldImg.src=window.URL.createObjectURL(this.files[0])" type="file" class="form-control" id="productImg">

                                <input type="text" class="d-none" id="updateID" >
                                <input type="text" class="d-none" id="filePath" >

                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button id="modal-close" class="btn bg-gradient-primary" data-bs-dismiss="modal" aria-label="Close">Close</button>
                <button onclick="Save()" id="save-btn" class="btn bg-gradient-success" >Save</button>
            </div>
        </div>
    </div>
</div>


<script>

    async function UpdateFillCategoryDropDown (){

        let res = await axios.get("/list-category")
        res.data.forEach(function (item,i){
                let option= `<option value=${item['id']}>${item['name']}</option>`
                $("#productCategory").append(option);

            }
        )}

        async function FillUpUpdateForm(id, filePath){
        document.getElementById('updateID').value=id;
        document.getElementById('filePath').value=filePath;
        document.getElementById('oldImg').src=filePath;

        showLoader();
        await FillCategoryDropDown();
            let res = await axios.post("/product-by-id",{id:id})
        hideLoader();

    }




    async function update() {

        let productCategoryUpdate = document.getElementById('productCategoryUpdate').value;
        let productNameUpdate = document.getElementById('productNameUpdate').value;
        let productPriceUpdate = document.getElementById('productPriceUpdate').value;
        let productUnitUpdate = document.getElementById('productUnitUpdate').value;
        let UpdateID = document.getElementById('UpdateID').value;
        let filePath = document.getElementById('filePath').value;
        let productImageUpdate = document.getElementById('productImgUpdate').files[0];

        if(productCategoryUpdate.length===0){
            errorToast("Product Category Required!")
        }
        else if(productNameUpdate.length===0){
            errorToast("Product Name Required!")
        }
        else if(productPriceUpdate.length===0){
            errorToast("Product Price Required!")
        }
        else if(productUnitUpdate.length===0){
            errorToast("Product Unit Required!")
        }

        else{

            document.getElementById('modal-close').click();

            let formData=new FormData();
            formData.append('img',productImgUpdate)
            formData.append('name',productNameUpdate)
            formData.append('price',productPriceUpdate)
            formData.append('unit',productUnitUpdate)
            formData.append('category_id',productCategoryUpdate)
            formData.append('file_path',filePath)

            const config ={
                headers:{
                    'content-type':'multipart/form-data'
                }
            }
            showLoader();
            let res = await axios.post("/create-product",formData,config)
            hideLoader();

            if(res.status===201){
                successToast('Request Completed');
                document.getElementById("save-form").reset();
                await getList();
            }
            else{
                errorToast("Request Failed!")
            }
        }

    }
</script>



