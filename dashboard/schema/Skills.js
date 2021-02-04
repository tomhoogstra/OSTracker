cube(`Skills`, {
  sql: `SELECT * FROM ostracker.skills`,
  
  joins: {
    
  },
  
  measures: {
    count: {
      type: `count`,
      drillMembers: [id, skillname]
    }
  },
  
  dimensions: {
    id: {
      sql: `id`,
      type: `number`,
      primaryKey: true
    },
    
    skillname: {
      sql: `${CUBE}.\`skillName\``,
      type: `string`
    }
  }
});
