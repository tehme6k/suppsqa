

export interface Inventory {
  id: number;
  lot_number: string;
  adjustment_type: string;
  quantity: number;
  uom: string;
  expiration_date: string;
  created_at: string;

}

export interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedInventories {
  data: Inventory[];
  links: PaginationLink[];
  // Add other pagination meta data if needed, like current_page, last_page, etc.
}