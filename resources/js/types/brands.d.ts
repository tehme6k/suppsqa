export interface Brand {
  id: number;
  name: string;
  created_at: string;
}

export interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedBrands {
  data: Brand[];
  links: PaginationLink[];
  // Add other pagination meta data if needed, like current_page, last_page, etc.
}