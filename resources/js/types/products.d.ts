export interface Category {
  id: number;
  name: string;
}

export interface User {
  id: number;
  name: string;
}

export interface Product {
  id: number;
  name: string;
  quantity: number,
  created_at: string;
  category: Category;
  user: User;
}

export interface PaginationLink {
  url: string | null;
  label: string;
  active: boolean;
}

export interface PaginatedProducts {
  data: Product[];
  links: PaginationLink[];
  // Add other pagination meta data if needed, like current_page, last_page, etc.
}