require("./bootstrap");

import Alpine from "alpinejs";
import { getSellingPrice, recordSale, getSales } from "./cofee-sales";

window.Alpine = Alpine;

Alpine.start();

window.getSellingPrice = getSellingPrice;
window.recordSale = recordSale;
window.getSales = getSales;
