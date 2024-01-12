<template>
  <div class="ticket">
    <table>
      <tr>
        <th v-for="title in priceTitle">{{ $t(title.name) }}</th>
      </tr>
      <tr v-for="ticket in ticket">
        <td>{{ $t(ticket.tic_name) }}</td>
        <td>NT {{ $t(ticket.tic_price) }}</td>
        <td>{{ $t(ticket.tic_info) }}</td>
      </tr>
      <tr>
        <td colspan="3">※{{ $t("未滿4歲且有家長陪同的幼童可免費入場") }}</td>
      </tr>
    </table>
  </div>
</template>

<script>
export default {
  data() {
    return {
      priceTitle: [{ name: "票種" }, { name: "價格" }, { name: "適用對象" }],
      ticket: [
        // { name: "一般票", price: "NT 500", object: "限18歲(含)以上成人使用" },
        // {
        //   name: "學生票",
        //   price: "NT 300",
        //   object: "限12歲(含)以上持學生證之學生適用",
        // },
        // {
        //   name: "孩童票",
        //   price: "NT 200",
        //   object: "限4歲(含)以上及未滿12歲兒童適用",
        // },
        // {
        //   name: "愛心票",
        //   price: "NT 200",
        //   object:
        //     "限持有身心障礙證明者、身心障礙者的1位陪同者、孕婦、滿65歲以上長者適用",
        // },
        // { name: "團體票", price: "NT 350", object: "15人以上適用" },
      ],
    };
  },
  mounted() {
    fetch(`${this.$store.state.APIurl}ticketMg.php`)
      .then(function (response) {
        return response.json();
      })
      .then((data) => {
        this.ticket = data.filter((item) => item.tick_state == "1");
      });
  },
};
</script>

<style lang="scss" scoped>
.ticket {
  max-width: 1200px;
  width: 100%;
  margin: 30px auto 0;

  table {
    margin: auto;
    font-size: 16px;
    border-radius: 5px;
    background-color: map-get($colors, "secondary");
    color: map-get($colors, "light");

    tr:nth-child(2n) {
      background-color: map-get($colors, "light");
      color: map-get($colors, "dark");
    }

    td,
    th {
      padding: 15px 30px;
      text-align: left;
    }
  }
}
</style>
