export const filterCategoriesByType = (categories, isIncomeView) => {
  if (!Array.isArray(categories)) return [];

  return categories.filter((category) =>
    isIncomeView ? category.type === `1` : category.type === `2`
  );
};

export const getDoughnutData = ({
  expandedCategoryId,
  filteredCategories,
  isIncomeView,
}) => {
  if (!Array.isArray(filteredCategories)) return { labels: [], values: [] };

  if (expandedCategoryId) {
    const category = filteredCategories.find(
      (cat) => cat.id === expandedCategoryId
    );
    if (!category) return { labels: [], values: [] };

    const filteredTransactions = category.transactions.filter((tx) =>
      isIncomeView ? tx.amount > 0 : tx.amount < 0
    );

    return {
      labels: filteredTransactions.map((tx) => tx.text),
      values: filteredTransactions.map((tx) => Math.abs(tx.amount)),
    };
  }

  return {
    labels: filteredCategories.map((category) => category.category),
    values: filteredCategories.map((category) =>
      Math.abs(category.total_amount)
    ),
  };
};
