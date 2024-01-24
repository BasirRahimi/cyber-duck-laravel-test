require("./bootstrap");

import Alpine from "alpinejs";
import { getSellingPrice, recordSale } from "./cofee-sales";

window.Alpine = Alpine;

Alpine.start();

window.getSellingPrice = getSellingPrice;
window.recordSale = recordSale;
