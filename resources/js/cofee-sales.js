export const getSellingPrice = async (quantity, unitCost, productId) => {
    let response = await axios.get(
        `/api/v1/selling-price?quantity=${quantity}&unit-cost=${unitCost}&product-id=${productId}`
    );
    if (response.status !== 200) {
        throw new Error("Something went wrong!");
    }
    return response.data.selling_price;
};

export const recordSale = async (data) => {
    const { quantity, unitCost, productId, sellingPrice } = data;

    let response = await axios.post("/api/v1/sales", {
        quantity,
        unitCost,
        productId,
        sellingPrice,
    });

    if (response.status !== 201) {
        throw new Error("Something went wrong!");
    }

    return response.data.sale;
};
