document.addEventListener("alpine:init", () => {
  Alpine.data("products", () => ({
    items: [
      {
        id: 1,
        name: "Aerox",
        img: "Aerox.png",
        price: 30000000,
      },
      {
        id: 2,
        name: "Beat",
        img: "Beatkarbu.jpg",
        price: 20000000,
      },
      {
        id: 3,
        name: "Vario",
        img: "Vario.jpg",
        price: 35000000,
      },
    ],
  }));

  Alpine.store("cart", {
    items: [],
    total: 0,
    quantity: 0,
    add(newItem) {
      this.item.push(newItem);
      this.quantity++;
      this.total += newItem.price;
      console.log(this.total);
    },
  });
});

//confrupiah
const rupiah = (number) => {
  return new Intl.NumberFormat("id-ID", {
    style: "currency",
    currency: "IDR",
    minimumFractionDigits: 0,
  }).format(number);
};
