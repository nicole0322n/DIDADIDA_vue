<template>
    <div class="news_all">
        <div class="select">
            <div class="add">
                <button @click="news_content">+新增項目</button>
                <search @transferSearch="searchClick" :txt="'搜尋標題或內容'"></search>
            </div>
        </div>
        <div class="news_content">
            <div class="title">
                <ul>
                    <li>消息編號/消息圖片</li>
                    <li>標題/內容</li>
                    <li>上傳時間</li>
                    <li>
                        <filterCategory @category="filterCategory">
                        </filterCategory>
                        <filterState @state="filterState" />
                    </li>
                </ul>
            </div>
            <div class="content">
                <ul class="no_data" v-if="this.displayednews.length == 0">暫無符合資料</ul>
                <ul v-else v-for="(item, index) in displayednews" :key="index">
                    <li>
                        <div class="news_id">
                            {{ item.news_id }}
                        </div>
                    </li>
                    <li>
                        <div class="img">
                            <div class="picBox">
                                <img :src="item.news_img_url" :alt="item.news_img ? item.news_img : '圖片大小需小於2MB'">
                            </div>

                            <div class="file_btn">
                                <input type="file" @change="fileChange($event, item, index)" :ref="'fileInput' + index"
                                    :disabled="item.disabled" name="image" :title="item.news_img">
                                <i class="fa-regular fa-trash-can" style="color: #ffffff;" @click="deleteImage(index)"
                                    v-if="!item.disabled && item.news_img"></i>
                            </div>
                        </div>
                        <div>{{ item.news_img }}</div>
                        <p class="file_name"></p>

                    </li>
                    <li>
                        <textarea name="news_title" id="" placeholder="標題" class="news_name" :disabled="item.disabled"
                            v-model="item.news_title"></textarea>
                        <textarea name="news_conteny" id="" placeholder="內容" class="news_txt" :disabled="item.disabled"
                            v-model="item.news_content"></textarea>
                    </li>
                    <li>
                        <div class="time" name="news_date">{{ item.news_date }}</div>
                    </li>
                    <li>
                        <div class="state">
                            <select name="news_state" id="" v-model="item.news_category" :disabled="item.disabled">
                                <option value="">選擇分類</option>
                                <option value="表演">表演</option>
                                <option value="優惠">優惠</option>
                                <option value="活動">活動</option>
                            </select>
                        </div>
                        <switchBtn :item="item.news_state" :index="index" v-model="item.news_state" :onText="'上架'"
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
            <div class="news_count">總共有{{ newsCount }}件消息</div>
            <Page :total="this.filterednews.length" @on-change="updatePage" :page-size="pageSize" v-model="this.currentPage"
                class="page" />
        </div>
    </div>
</template>

<script>
import switchBtn from '../../components/backComponents/toggleBtn.vue'
import filterState from '../../components/backComponents/stateFilter.vue'
import search from '../../components/backComponents/search.vue'
import filterCategory from '../../components/backComponents/category.vue'

export default {
    data() {
        return {
            allnews: [],
            filterednews: [],
            displayednews: [],
            pageSize: 3,
            currentPage: 1,
            selectedState: "狀態",
            selectedCategory: "",
            searchInput: "",
        }
    },

    components: {
        switchBtn,
        filterState,
        search,
        filterCategory
    },
    async mounted() {
        await fetch(`${this.$store.state.APIurl}newsSelect.php`)
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
                    myJson[i].news_img_url = `${this.$store.state.chooseImgSrc}/all_images/news/${myJson[i].news_img}`;
                }
                this.allnews = myJson;
                console.log(this.allnews);
            })
            .catch((error) => {
                console.error('Fetch error:', error);
            });
        this.filterCategory(this.selectedCategory);
        this.filterState(this.selectedState);
        this.updatePage(1);
    },
    methods: {
        //篩選
        applyFilters() {
            let filterednews = this.allnews;

            if (this.selectedCategory !== "") {
                filterednews = filterednews.filter(
                    (item) => item.news_category === this.selectedCategory
                );
            }
            if (this.selectedState === "0" || this.selectedState === "1") {
                filterednews = filterednews.filter(
                    (item) => item.news_state === this.selectedState
                );
            }

            const searchInput = this.searchInput.toUpperCase();
            if (searchInput.trim() !== "") {
                filterednews = filterednews.filter((item) => {
                    const search_content =
                        item.news_title.toUpperCase() + item.news_content.toUpperCase();
                    return search_content.includes(searchInput);
                });
            }

            // 更新 filterednews 数组
            this.filterednews = filterednews;
            this.changePic = "";
            setTimeout(() => {
                this.updatePage(1);
            }, 300);
        },
        filterCategory(data) {
            this.selectedCategory = data;
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
            this.currentPage = page
            const startIdx = (this.currentPage - 1) * this.pageSize
            const endIdx = startIdx + this.pageSize
            this.displayednews = this.filterednews.slice(startIdx, endIdx);
        },
        //上下架
        updateNewsState(index, state) {
            this.displayednews[index].news_state = state;
        },

        deleteNews(index) {
            if (confirm("取消此筆新增嗎?")) {
                this.displayednews.splice(index, 1);
                this.changePic = "";
            }
        },
        deleteImage(index) {
            const item = this.displayednews[index];

            if (confirm("確定刪除圖片嗎？")) {

                document.querySelectorAll(".picBox img")[index].src = "";
                item.news_img = '';
                alert("圖片已成功刪除");


            }
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
                item.news_img_url = readFile.result;
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
                if (!item.news_title || !item.news_content) {
                    alert("請將標題和內容填滿");
                    return;
                } else if (!item.news_category) {
                    alert("請選擇分類");
                    return;
                } else if (this.changePic) { // 检查是否选择了新图片
                    this.displayednews[index].disabled = true;
                    e.target.innerText = "修改";

                    const formData = new FormData();
                    let news_id = item.news_id;
                    let news_title = item.news_title;
                    let news_content = item.news_content;
                    let news_date = item.news_date;
                    let news_category = item.news_category;
                    let news_state = item.news_state;

                    formData.append("news_id", news_id);
                    formData.append("news_title", news_title);
                    formData.append("news_content", news_content);
                    formData.append("news_date", news_date);
                    formData.append("news_category", news_category);
                    formData.append("news_state", news_state);
                    formData.append("image", this.changePic);

                    fetch(`${this.$store.state.APIurl}news.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((result) => {
                            alert("更新成功");
                            // 重新取資料
                            this.changePic = "";
                            this.refreshNewsData();
                        });
                } else {
                    // 如果没有选择新图片，只更新其他信息
                    const formData = new FormData();
                    this.displayednews[index].disabled = true;
                    e.target.innerText = "修改";
                    this.changePic = "";

                    let news_id = item.news_id;
                    let news_title = item.news_title;
                    let news_content = item.news_content;
                    let news_date = item.news_date;
                    let news_category = item.news_category;
                    let news_state = item.news_state;

                    formData.append("news_id", news_id);
                    formData.append("news_title", news_title);
                    formData.append("news_content", news_content);
                    formData.append("news_date", news_date);
                    formData.append("news_category", news_category);
                    formData.append("news_state", news_state);

                    fetch(`${this.$store.state.APIurl}news.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((result) => {
                            alert("更新成功");
                            // 重新取資料
                            this.changePic = "";
                            this.refreshNewsData();
                        });
                }
            } else {
                this.displayednews[index].disabled = false;
                e.target.innerText = "確認";
            }
        },


        news_content() {
            //上傳時間
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}`;

            this.filterednews = this.allnews;
            this.updatePage(Math.ceil(this.filterednews.length / this.pageSize));

            this.displayednews.push({
                news_id: this.allnews.length + 1,
                news_title: "",
                news_img: "",
                news_content: "",
                news_date: formattedDateTime,
                news_category: "",
                news_state: "1",
                disabled: false,
                exist: false,
            });
        },
        createNew(index, e, item) {
            if (e.target.innerText == "新增") {
                if (!item.news_title || !item.news_content) {
                    alert("請將標題和內容填滿");
                    return;
                }
                else if (!this.changePic) {
                    alert("請選擇圖片");
                    return;
                }
                else if (!item.news_category) {
                    alert("請選擇分類");
                    return;
                }



                const formData = new FormData();
                let news_id = item.news_id;
                let news_title = item.news_title;
                let news_content = item.news_content;
                let news_date = item.news_date;
                let news_category = item.news_category;
                let news_state = item.news_state;

                formData.append("news_id", news_id);
                formData.append("news_title", news_title);
                formData.append("news_content", news_content);
                formData.append("news_date", news_date);
                formData.append("news_category", news_category);
                formData.append("news_state", news_state);
                formData.append("image", this.changePic);

                this.displayednews[index].disabled = true;

                fetch(`${this.$store.state.APIurl}newsInsert.php`, {
                    method: "POST",
                    body: formData,
                })
                    .then((res) => res.json())
                    .then((result) => {
                        alert("新增成功");
                        // 重新獲取資料
                        this.refreshNewsData();

                    })
                return;


            }
        },
        async refreshNewsData() {
            await fetch(`${this.$store.state.APIurl}newsSelect.php`)
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
                        myJson[i].news_img_url = `${this.$store.state.chooseImgSrc}/all_images/news/${myJson[i].news_img}`;
                    }
                    this.allnews = myJson;
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


    },


    computed: {

        newsCount() {
            return this.filterednews.length;
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

.news_all {
    .select {
        .add {
            display: flex;
            justify-content: space-between;
        }

    }

    .news_content {
        .title {
            width: 100%;
            border-bottom: 1px solid #000;
            margin: 2rem 0;
            font-weight: 800;

            ul {
                width: 100%;
                margin: auto;
                display: flex;


                li {
                    &:nth-of-type(1) {
                        width: 35%;
                        text-align: center;
                    }

                    &:nth-of-type(2) {
                        width: 30%;
                        text-align: center;
                    }

                    &:nth-of-type(3) {
                        width: 10%;
                        text-align: center;
                    }

                    &:nth-of-type(4) {
                        width: 25%;
                        padding-left: 1rem;
                        display: flex;
                        text-align: left;
                    }
                }
            }
        }

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
                        width: 30%;

                        p {
                            width: 100%;
                            overflow: hidden;
                            text-overflow: ellipsis;
                        }
                    }

                    &:nth-of-type(3) {
                        text-align: center;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-evenly;
                        width: 30%;
                        height: 12rem;
                    }

                    &:nth-of-type(4) {
                        width: 10%;
                    }

                    &:nth-of-type(5) {
                        width: 15%;
                        height: 10rem;
                        display: flex;
                        flex-direction: column;
                        justify-content: space-evenly;

                        select {
                            width: 100%;
                        }
                    }

                    &:nth-of-type(6) {
                        width: 10%;
                        text-align: center;
                    }
                }

                textarea {
                    width: 90%;
                    height: 8rem;
                    margin: auto;
                    box-sizing: border-box;
                    overflow: auto;
                    padding: 0.2rem 0.5rem;
                    line-height: 1.5rem;
                }

                .news_name {
                    max-height: 30px;
                }

                .img {
                    width: 90%;
                    aspect-ratio: 1/0.7;
                    position: relative;


                    .picBox {
                        position: absolute;
                        width: 100%;
                        height: 100%;

                        img {
                            width: 100%;
                            height: 100%;


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

    //內容end
    .news_count {

        border-top: 1px solid #3f3636;
        text-align: right;
        font-size: 14px;
    }

    //分頁
    .page {
        text-align: center;
    }
}
</style>
