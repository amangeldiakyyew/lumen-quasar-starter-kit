export default {
  data: {
    firstPage: 1,
    currentPage: 1,
    lastPage: 1,
    perPage: 0,
    from: 1,
    to: 1,
    total: 1,
  },
  setData(paginationData, res) {
    paginationData.lastPage = res.last_page;
    paginationData.currentPage = res.current_page;
    paginationData.perPage = res.per_page;
    paginationData.total = res.total;
    paginationData.from = res.from;
    paginationData.to = res.to;
  }

};
