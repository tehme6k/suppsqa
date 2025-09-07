export interface Vendor {
  id: number;
  name: string;
  created_at: string;
}

export interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedVendors {
  data: Vendor[];
  links: PaginationLink[];
  // Add other pagination meta data if needed, like current_page, last_page, etc.
}