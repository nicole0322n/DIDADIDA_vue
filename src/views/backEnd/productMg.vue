<template>
    <div class="prod_all">
        <div class="select">
            <div class="add">
                <button @click="news_content">+新增項目</button>
                <search @transferSearch="searchClick" :txt="'搜尋商品名稱或描述'"></search>
            </div>
            <filterProduct @category="filterCategory" @price="filterPrice" @state="filterState" />
        </div>
        <div class="prod_content">
            <div class="content">
                <ul class="no_data" v-if="displayedProducts.length == 0">暫無符合資料</ul>
                <ul v-for="(item, index) in displayedProducts" :key="index">
                    <li>{{ item.prod_id }}</li>
                    <li>
                        <div class="img">
                            <div class="picBox">
                                <img :src="item.prod_img_url" :alt="item.prod_img ? item.prod_img : '圖片需小於2MB'">
                            </div>

                            <div class="file_btn">
                                <input type="file" @change="fileChange($event, item, index)" :ref="'fileInput' + index"
                                    :disabled="item.disabled" name="image" :title="item.prod_img">
                                <i class="fa-regular fa-trash-can" style="color: #ffffff;" @click="deleteImage(index)"
                                    v-if="!item.disabled && item.prod_img"></i>

                            </div>
                        </div>
                        <div>{{ item.prod_img }}</div>
                        <p class="file_name"></p>
                    </li>


                    <!-- 商品名稱/種類 -->
                    <li>
                        <select name="" id="" v-model="item.prod_category" :disabled="item.disabled">
                            <option value="">選擇分類</option>
                            <option value="抱枕">抱枕</option>
                            <option value="玩偶">玩偶</option>
                            <option value="配飾">配飾</option>
                        </select>
                        <textarea name="" id="" placeholder="商品名稱" class="prod_name" :disabled="item.disabled"
                            v-model="item.prod_name"></textarea>
                    </li>
                    <!-- 價格 -->
                    <li>
                        <label for="price">
                            <input type="number" :disabled="item.disabled" v-model="item.prod_price" min="100"
                                placeholder="價錢">NT
                        </label>
                    </li>
                    <!-- 商品描述 -->
                    <li>
                        <textarea name="" id="" placeholder="商品描述" class="news_txt" :disabled="item.disabled"
                            v-model="item.prod_info"></textarea>
                    </li>
                    <li>
                        <switchBtn :item="item.prod_listed" :index="index" v-model="item.prod_listed" :onText="'上架'"
                            :offText="'下架'" @toggle="updateNewsState" :disabled="item.disabled"></switchBtn>

                    </li>
                    <li>
                        <button class="update" @click="updateNews(index, $event, item)" v-if="item.exist">{{ item.disabled ?
                            '修改' : '確認'
                        }}</button>

                        <button class="insert" @click="createNew(index, $event, item)" v-if="!item.exist">新增</button>
                        <button class="insert" @click="deleteNews(index)" v-if="!item.exist">取消</button>
                    </li>

                </ul>
            </div>

            <div class="prod_count">總共有{{ prodCount }}件商品</div>
            <Page :total="this.filteredProducts.length" @on-change="updatePage" :page-size="pageSize"
                v-model="this.currentPage" class="page" />
        </div>
    </div>
</template>

<script>
import switchBtn from '../../components/backComponents/toggleBtn.vue'
import filterProduct from '../../components/backComponents/productFilter.vue'
import search from '../../components/backComponents/search.vue'

export default {
    data() {
        return {
            allProduct: [],
            filteredProducts: [], // 篩選後的商品
            displayedProducts: [],
            selectedItem: "",
            selectedPrice: "價格",
            selectedState: "",
            searchInput: "",
            pageSize: 3,
            currentPage: 1,
        }
    },
    components: {
        switchBtn,
        filterProduct,
        search
    },
    async mounted() {
        await fetch(`${this.$store.state.APIurl}productSelect.php`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then((myJson) => {
                for (let i = 0; i < myJson.length; i++) {
                    myJson[i].disabled = true;
                    myJson[i].exist = true;
                    myJson[i].prod_img_url = `${this.$store.state.chooseImgSrc}/all_images/product/${myJson[i].prod_img}`;
                }
                this.allProduct = myJson;
                console.log(this.allProduct);
            })
            .catch((error) => {
                console.error('Fetch error:', error);
                // 在这里可以添加适当的错误处理逻辑，例如显示错误消息给用户
            });

        this.filterCategory(this.selectedItem);
        this.filterPrice(this.selectedPrice);
        this.filterState(this.selectedState);
        this.updatePage(1);
    },
    methods: {
        deleteImage(index) {
            const item = this.displayedProducts[index];

            if (confirm("確定刪除圖片嗎？")) {

                document.querySelectorAll(".picBox img")[index].src = "";
                item.prod_img = '';
                alert("圖片已成功刪除");


            }
        },
        updateNewsState(index, state) {
            this.displayedProducts[index].prod_listed = state;
        },

        deleteNews(index) {
            if (confirm("取消此筆新增嗎?")) {
                this.changePic="";
                this.displayedProducts.splice(index, 1);
            }
        },
        news_content() {


            //上傳時間
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}`;

            this.filteredProducts = this.allProduct;

            this.updatePage(Math.ceil(this.filteredProducts.length / this.pageSize));


            this.displayedProducts.push({
                prod_id: this.allProduct.length + 1,
                prod_name: "",
                prod_price: "",
                prod_info: "",
                prod_date: formattedDateTime,
                prod_listed: "1",
                prod_category: "",
                prod_img: "",
                disabled: false,
                exist: false,
            });
        },
        createNew(index, e, item) {
            if (e.target.innerText == "新增") {
                if (!item.prod_name || !item.prod_info) {
                    alert("請將商品名和描述填滿");
                    return;
                }
                else if (!this.changePic) {
                    alert("請選擇圖片");
                    return;
                }
                else if (!item.prod_category) {
                    alert("請選擇分類");
                    return;
                }
                else if (item.prod_price < 100) {
                    alert("價錢為必填且需大於100");
                    return;
                }



                const formData = new FormData();
                let prod_id = item.prod_id;
                let prod_name = item.prod_name;
                let prod_price = item.prod_price;
                let prod_info = item.prod_info;
                let prod_listed = item.prod_listed;
                let prod_category = item.prod_category;
                let prod_date = item.prod_date;

                formData.append("prod_id", prod_id);
                formData.append("prod_name", prod_name);
                formData.append("prod_price", prod_price);
                formData.append("prod_info", prod_info);
                formData.append("prod_listed", prod_listed);
                formData.append("prod_category", prod_category);
                formData.append("prod_date", prod_date);
                formData.append("image", this.changePic);

                this.displayedProducts[index].disabled = true;
                this.displayedProducts[index].exist = true;

                fetch(`${this.$store.state.APIurl}productInsert.php`, {
                    method: "POST",
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((result) => {
                        alert("新增成功");
                        // 重新獲取資料
                        this.changePic = "";
                        this.refreshNewsData();


                    })
                return;


            }
        },
        async refreshNewsData() {
            await fetch(`${this.$store.state.APIurl}productSelect.php`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then((myJson) => {


                    for (let i = 0; i < myJson.length; i++) {
                        myJson[i].disabled = true;
                        myJson[i].exist = true;
                        myJson[i].prod_img_url = `${this.$store.state.chooseImgSrc}/all_images/product/${myJson[i].prod_img}`;
                    }

                    this.allProduct = myJson;
                    this.$nextTick(() => {
                        this.applyFilters();
                        this.changePic = ""; 
                        
                    });



                })
                .catch((error) => {
                    console.error('Fetch error:', error);
                    // 在这里可以添加适当的错误处理逻辑，例如显示错误消息给用户
                });
        },
        fileChange(e, item, index) {
            let file = e.target.files[0];
            if (file.size > 2 * 1024 * 1024) {
                alert("請選擇一個小於2MB的圖片");
                return;
            }

            this.changePic = file;
            console.log("file", file);

            let readFile = new FileReader();
            readFile.readAsDataURL(file);
            readFile.addEventListener("load", () => {
                item.prod_img_url = readFile.result;
            });
        },
        formatFileSize(bytes) {
            if (bytes === 0) return "0 Bytes";
            const k = 1024;
            const sizes = ["Bytes", "KB", "MB", "GB", "TB"];
            const i = Math.floor(Math.log(bytes) / Math.log(k));
            return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + " " + sizes[i];
        },



        updateNews(index, e, item) {
            if (e.target.innerText === "確認") {
                if (!item.prod_name || !item.prod_info) {
                    alert("請將商品名和描述填滿");
                    return;
                }
                else if (!item.prod_category) {
                    alert("請選擇分類");
                    return;
                }
                else if (item.prod_price < 100) {
                    alert("價錢為必填且需大於100");
                    return;
                } else if (this.changePic) { // 检查是否选择了新图片
                    const formData = new FormData();
                    this.displayedProducts[index].disabled = true;
                    e.target.innerText = "修改";

                    let prod_id = item.prod_id;
                    let prod_name = item.prod_name;
                    let prod_price = item.prod_price;
                    let prod_info = item.prod_info;
                    let prod_listed = item.prod_listed;
                    let prod_category = item.prod_category;
                    let prod_date = item.prod_date;

                    formData.append("prod_id", prod_id);
                    formData.append("prod_name", prod_name);
                    formData.append("prod_price", prod_price);
                    formData.append("prod_info", prod_info);
                    formData.append("prod_listed", prod_listed);
                    formData.append("prod_category", prod_category);
                    formData.append("prod_date", prod_date);
                    formData.append("image", this.changePic);

                    fetch(`${this.$store.state.APIurl}productUpdate.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((result) => {
                            alert("更新成功");
                            // 重新取資料
                            this.changePic="";
                            this.refreshNewsData();
                            this.applyFilters();
                            this.updatePage(this.currentPage);
                            
                        });
                } else {
                    // 如果没有选择新图片，只更新其他信息
                    this.displayedProducts[index].disabled = true;
                    e.target.innerText = "修改";
                    this.changePic = "";


                    const formData = new FormData();
                    let prod_id = item.prod_id;
                    let prod_name = item.prod_name;
                    let prod_price = item.prod_price;
                    let prod_info = item.prod_info;
                    let prod_listed = item.prod_listed;
                    let prod_category = item.prod_category;
                    let prod_date = item.prod_date;


                    formData.append("prod_id", prod_id);
                    formData.append("prod_name", prod_name);
                    formData.append("prod_price", prod_price);
                    formData.append("prod_info", prod_info);
                    formData.append("prod_listed", prod_listed);
                    formData.append("prod_category", prod_category);
                    formData.append("prod_date", prod_date);

                    fetch(`${this.$store.state.APIurl}productUpdate.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((result) => {
                            alert("更新成功");
                            // 重新取資料
                            this.changePic = "";
                            this.refreshNewsData();
                            this.applyFilters();
                            this.updatePage(this.currentPage);
                            
                        });
                }
            } else {
                this.displayedProducts[index].disabled = false;
                e.target.innerText = "確認";
            }
        },

        //篩選
        applyFilters() {
            let filteredProducts = this.allProduct;
            if (this.selectedItem !== "") {
                filteredProducts = filteredProducts.filter(
                    (item) => item.prod_category === this.selectedItem
                );
            }


            if (this.selectedPrice === '低到高') {
                filteredProducts.sort((a, b) => a.prod_price - b.prod_price);
            } else if (this.selectedPrice === '高到低') {
                filteredProducts.sort((a, b) => b.prod_price - a.prod_price);
            }


            if (this.selectedState === "0" || this.selectedState === "1") {
                filteredProducts = filteredProducts.filter(
                    (item) => item.prod_listed === this.selectedState
                );
            }

            const searchInput = this.searchInput.toUpperCase();
            if (searchInput.trim() !== "") {
                filteredProducts = filteredProducts.filter((item) => {
                    const search_content =
                        item.prod_name.toUpperCase() + item.prod_info.toUpperCase();
                    return search_content.includes(searchInput);
                });
            }

            // 更新 filteredProducts 数组
            this.filteredProducts = filteredProducts;
            this.changePic = "";
            setTimeout(() => {
                this.updatePage(1);
            }, 300);
        },

        filterCategory(data) {
            this.selectedItem = data;
            this.applyFilters();
        },

        filterPrice(data) {
            this.selectedPrice = data;
            this.applyFilters();
        },

        filterState(data) {
            this.selectedState = data;
            this.applyFilters();
        },
        searchClick(data) {
            this.searchInput = data;
            this.applyFilters();
        },
        updatePage(page) {
            this.changePic="";
            this.currentPage = page;
            const startIdx = (this.currentPage - 1) * this.pageSize;
            const endIdx = startIdx + this.pageSize;
            this.displayedProducts = this.filteredProducts.slice(startIdx, endIdx);
        },


    },
    computed: {
        prodCount() {
            return this.filteredProducts.length;
        },
    },
}
</script>
<style scoped lang="scss">
.no_data {
    display: flex;
    justify-content: center;
    padding: 2rem 0;

}

.prod_all {

    .add {
        display: flex;
        justify-content: space-between;
    }

    .prod_content {

        .content {
            ul {
                width: 100%;
                display: flex;
                align-items: center;
                margin: 1rem 0;

                input:disabled,
                textarea:disabled,
                select:disabled {
                    cursor: not-allowed;
                }

                li {
                    &:nth-of-type(1) {
                        width: 5%;
                        text-align: center;

                    }

                    &:nth-of-type(2) {
                        width: 17%;
                        text-align: center;
                    }

                    &:nth-of-type(3) {
                        width: 23%;
                        height: 10rem;
                        text-align: center;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-evenly;
                        padding: 1rem;

                    }

                    &:nth-of-type(4) {
                        width: 12%;
                        text-align: center;

                        input[type="number"] {
                            width: 70%;
                        }
                    }

                    &:nth-of-type(5) {
                        width: 20%;
                        height: 10rem;

                        textarea {
                            height: 90%;
                        }
                    }

                    &:nth-of-type(6) {
                        width: 15%;
                    }

                    &:nth-of-type(7) {
                        width: 8%;
                        text-align: center;
                    }
                }

                textarea {
                    // resize: none;
                    width: 100%;
                    box-sizing: border-box;
                    overflow: auto;
                    padding: 0.2rem 0.5rem;
                    line-height: 1.5rem;
                }


                .img {
                    width: 100%;
                    aspect-ratio: 1/1;
                    position: relative;


                    .picBox {
                        position: absolute;
                        width: 100%;
                        height: 100%;

                        img {
                            width: 100%;
                            aspect-ratio: 1/1;


                            &::after {
                                width: 100%;
                                height: 100%;
                                content: "\e09a\A" attr(alt);
                                font-size: 1rem;
                                font-family: FontAwesome;
                                color: rgb(100, 100, 100);
                                background-color: #c2baba;
                                position: absolute;
                                inset: 0;
                                z-index: 2;
                                pointer-events: none;
                                display: flex;
                                justify-content: center;
                                align-items: center;
                                white-space: pre;
                                text-align: center;
                            }
                        }
                    }


                    .file_btn {
                        width: 100%;
                        height: 100%;
                        position: relative;
                        display: flex;
                        align-items: center;
                        justify-content: center;

                        i {
                            width: 100%;
                            display: flex;
                            justify-content: center;
                            align-items: center;
                            position: absolute;
                            inset: 0;
                            opacity: 0;
                            z-index: 4;
                            font-size: 1.5rem;

                            &:hover {
                                opacity: 1;
                                background-color: rgba(0, 0, 0, 0.4);
                                transition: all .3s;

                            }
                        }



                        input[type="file"] {
                            width: 100%;
                            height: 100%;
                            position: absolute;
                            inset: 0;
                            opacity: 0;
                            font-size: 0;
                            cursor: pointer;

                            &:disabled {
                                cursor: not-allowed;
                            }
                        }

                    }
                }


            }
        }
    }

    //商品內容end
    .prod_count {

        border-top: 1px solid #3f3636;
        text-align: right;
        font-size: 14px;
    }

    //分頁
    .page {
        width: 100%;
        text-align: center;
    }
}
</style>
