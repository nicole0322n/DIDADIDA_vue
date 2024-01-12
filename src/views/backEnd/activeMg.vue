<template>
    <div class="select">
        <div class="add" @click="new_content">
            <button>+新增項目</button>
        </div>
    </div>

    <table>
        <tr>
            <th>圖片</th>
            <th>標題/內容</th>
            <th>上傳時間</th>
            <th>開始/結束時間</th>
            <th>上/下架</th>
            <th>編輯</th>
        </tr>
        <tr v-for="(item, index) in allactive" :key="index">
            <td>
                <div class="picBox">
                    <img :src="item.active_img_url" :alt="item.active_img ? item.active_img : '未選圖片'">
                </div>
                <input type="file" accept="image/*" @change="fileChange($event, index)" :ref="'fileInput' + index"
                    :disabled="item.disabled" name="image" :title="item.active_img">
            </td>
            <td>
                標題:<input type="text" v-model="item.active_title" :disabled="item.disabled"><br>
                內容:<input type="text" v-model="item.active_content" :disabled="item.disabled">
            </td>
            <td>{{ item.active_date }}</td>
            <td>
                開始時間:<input type="date" v-model="item.active_star" name="active_star" :disabled="item.disabled"><br>
                結束時間:<input type="date" v-model="item.active_end" name="active_end" :disabled="item.disabled">
            </td>
            <td>
                <input type="radio" :id="'on_' + index" :name="'select_onOff_' + index" :disabled="item.disabled"
                    v-model="item.active_state" value="1">上架<br>
                <input type="radio" :id="'off_' + index" :name="'select_onOff_' + index" :disabled="item.disabled"
                    v-model="item.active_state" value="0">下架
            </td>
            <td>
                <button class="update" @click="updateNews(index, $event, item)" v-if="item.exist">{{ item.disabled ?
                    '修改' : '確認'
                }}</button>
                <button @click="createNew(index, $event, item)" v-if="!item.exist">新增</button><br>
                <button @click="deleteNew(index)" v-if="!item.exist">刪除</button>
            </td>
        </tr>
    </table>
</template>
<script>
export default {
    data() {
        return {
            allactive: [],
        }
    },
    mounted() {
        fetch(`${this.$store.state.APIurl}activeSelect.php`)
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((myJson) => {
                for (let i = 0; i < myJson.length; i++) {
                    myJson[i].disabled = true;
                    myJson[i].exist = true;
                    myJson[i].active_img_url = `${this.$store.state.chooseImgSrc}/all_images/active/${myJson[i].active_img}`;
                }
                this.allactive = myJson;
                console.log(this.allactive);
            })
            .catch((error) => {
                console.error("Fetch error:", error);
                // 在这里可以添加适当的错误处理逻辑，例如显示错误消息给用户
            });
    },
    methods: {
        deleteNew(index) {
            if (confirm("取消此筆新增嗎?")) {
                this.allactive.splice(index, 1);
            }
        },

        fileChange(e, index) {
            this.changePic = "";
            let file = e.target.files[0];
            this.changePic = file;
            console.log("file", file);

            let readFile = new FileReader();
            readFile.readAsDataURL(file);
            readFile.addEventListener("load", () => {
                let image = new Image();
                image.src = readFile.result;
                console.log(image.src);
                image.style.width = "100%";
                image.style.height = "100%";
                document.querySelectorAll(".picBox")[index].innerHTML = "";
                document.querySelectorAll(".picBox")[index].appendChild(image);

                this.checkBase64Image(image.src, index);
            })
        },

        checkBase64Image(src, index) {
            const img = new Image();
            img.src = src;

            img.onload = () => {
                alert("圖片新增成功");
                this.allactive[index].active_img = src;
            };

            img.onerror = () => {
                alert("圖片新增失敗");
                document.querySelectorAll(".picBox img")[index].src = "";
                const fileInput = this.$refs['fileInput' + index];
                if (fileInput) {
                    fileInput.value = '';
                }
            }
        },

        updateNews(index, e, item) {
            if (e.target.innerText === "確認") {
                if (!item.active_title || !item.active_content) {
                    alert("請將標題和內容填滿");
                    return;
                } else if (this.changePic) {
                    this.allactive[index].disabled = true;

                    const formData = new FormData();
                    let active_id = item.active_id;
                    let active_title = item.active_title;
                    let active_content = item.active_content;
                    let active_date = item.active_date;
                    let active_state = item.active_state;
                    let active_star = item.active_star;
                    let active_end = item.active_end;

                    formData.append("active_id", active_id);
                    formData.append("active_title", active_title);
                    formData.append("active_content", active_content);
                    formData.append("active_date", active_date);
                    formData.append("active_state", active_state);
                    formData.append("active_star", active_star);
                    formData.append("active_end", active_end);
                    formData.append("active_img", this.changePic);

                    fetch(`${this.$store.state.APIurl}activeMg.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res, json())
                        .then((result) => {
                            alert("更新成功");
                            this.refreshNewsData();
                            this.changePic = "";
                        });
                } else {
                    this.allactive[index].disabled = true;

                    const formData = new FormData();
                    let active_id = item.active_id;
                    let active_title = item.active_title;
                    let active_content = item.active_content;
                    let active_date = item.active_date;
                    let active_state = item.active_state;
                    let active_star = item.active_star;
                    let active_end = item.active_end;

                    formData.append("active_id", active_id);
                    formData.append("active_title", active_title);
                    formData.append("active_content", active_content);
                    formData.append("active_date", active_date);
                    formData.append("active_state", active_state);
                    formData.append("active_star", active_star);
                    formData.append("active_end", active_end);
                    formData.append("image", this.changePic);

                    fetch(`${this.$store.state.APIurl}activeMg.php`, {
                        method: "POST",
                        body: formData,
                    })
                        .then((res) => res.json())
                        .then((result) => {
                            alert("更新成功");
                            this.refreshNewsData();
                            this.changePic = "";
                        });
                }
            } else {
                this.allactive[index].disabled = false;
                e.target.innerText = "確認";
            }
        },

        new_content() {
            //上傳時間
            const currentDate = new Date();
            const year = currentDate.getFullYear();
            const month = (currentDate.getMonth() + 1).toString().padStart(2, '0');
            const day = currentDate.getDate().toString().padStart(2, '0');
            const formattedDateTime = `${year}-${month}-${day}`;

            this.allactive.push({
                active_id: this.allactive.length + 1,
                active_title: "",
                active_img: "",
                active_content: "",
                active_date: formattedDateTime,
                active_state: "",
                active_star: "",
                active_end: "",
                disabled: false,
                exist: false,
            });
        },

        createNew(index, e, item) {
            if (e.target.innerHTML == "新增") {
                if (!item.active_title || !item.active_content) {
                    alert("請將標題和內容填滿");
                    return;
                }
                else if (!this.changePic) {
                    alert("請選擇圖片");
                    return;
                }
                const formData = new FormData();
                let active_id = item.active_id;
                let active_title = item.active_title;
                let active_content = item.active_content;
                let active_date = item.active_date;
                let active_state = item.active_state;
                let active_star = item.active_star;
                let active_end = item.active_end;

                formData.append("active_id", active_id);
                formData.append("active_title", active_title);
                formData.append("active_content", active_content);
                formData.append("active_date", active_date);
                formData.append("active_state", active_state);
                formData.append("active_star", active_star);
                formData.append("active_end", active_end);
                formData.append("image", this.changePic);

                this.allactive[index].disabled = true;

                fetch(`${this.$store.state.APIurl}activeInsert.php`, {
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
        refreshNewsData() {
            fetch(`${this.$store.state.APIurl}activeSelect.php`)
                .then((response) => {
                    if (!response.ok) {
                        throw new Error("Network response was not ok");
                    }
                    return response.json();
                })
                .then((myJson) => {
                    for (let i = 0; i < myJson.length; i++) {
                        myJson[i].disabled = true;
                        myJson[i].exist = true;
                    }
                    this.allactive = myJson;
                    console.log(this.allactive);
                })
                .catch((error) => {
                    console.error("Fetch error:", error);
                    // 在这里可以添加适当的错误处理逻辑，例如显示错误消息给用户
                });
        }
    },
}
</script>
  
<style scoped lang="scss">
table {
    width: 100%;
    margin: 10px 0;

    tr {
        border-bottom: 1px solid black;
        text-align: left;

        td {
            padding: 15px 0;
            line-height: 3;

            input {
                padding: 0 5px;
            }
        }
    }

    // tr:nth-child(2n) {
    //     display: flex;
    //     align-items: center;
    // }

    td:first-child {
        input {
            width: 200px;
        }
    }


    .picBox {
        width: 200px;
        height: 150px;
        background-color: #ddd;
        text-align: center;
        line-height: 11;

        img {
            width: 100%;
            height: 100%;
        }
    }

}
</style>
  