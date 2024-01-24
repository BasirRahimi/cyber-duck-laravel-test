require("./bootstrap");

import Alpine from "alpinejs";
import { getSellingPrice, recordSale } from "./cofee-sales";
import { formatDate } from "date-fns";

window.Alpine = Alpine;

window.getSellingPrice = getSellingPrice;
window.recordSale = recordSale;
window.formatDateStandard = (date) =>
    date ? formatDate(date, "yyyy-MM-dd HH:mm") : "";

Alpine.start();
