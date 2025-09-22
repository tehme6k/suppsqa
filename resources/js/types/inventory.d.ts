// resources/js/types/inventory.d.ts
export interface Inventory {
    lot_number: string;
    quantity: number;
    expiration_date: string | null;
}

export interface Product {
    id: number;
    name: string;
    sku: string;
    inventories: Inventory[];
}
