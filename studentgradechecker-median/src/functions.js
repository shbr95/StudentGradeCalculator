module.exports = {
    sortArray: function(input_text) {
            var lines = input_text.split("newline");
            console.log(lines)
            var moduleMarks = []
      
            for (const line of lines) {
              var lineArray = line.split(",")
              console.log(lineArray)
              var moduleMarksArray={
                "module": lineArray[0],
                "mark": lineArray[1]
              }
              moduleMarks = moduleMarks.concat(moduleMarksArray)
            const sorter = (a, b) => {
              return a.mark - b.mark;
            };
            const sortByMark = arr => {
                arr.sort(sorter);
            };
            sortByMark(moduleMarks);
            console.log(moduleMarks)
      }
        return moduleMarks
    }
  
    
        ,getMedianOdd: function(moduleMarks) {
        let median
        let middleIndex = Math.floor(moduleMarks.length/2)
        median = moduleMarks[middleIndex]["mark"]
        return median
      }
    
      ,getMedianEven: function (moduleMarks) {
        let median
        let middleIndex = Math.floor(moduleMarks.length/2)
        median = (parseInt(moduleMarks[middleIndex]["mark"]) + parseInt(moduleMarks[middleIndex - 1]["mark"])) / 2
        median = Math.round(median)
        return median
      }
  
  
    ,getOddEven:function(moduleMarks) {
      
      let oddEven
      if(moduleMarks.length%2 != 0){
        //odd case
        let middleIndex = Math.floor(moduleMarks.length/2)
        oddEven = "odd"
  
      } else {
        output.oddEven = "even"
      }
      return oddEven
     }
  
  
  
  
    ,GetModuleName1: function(moduleMarks) {
  
      let moduleName1
      let middleIndex = Math.floor(moduleMarks.length/2)
      moduleName1  = moduleMarks[middleIndex]["module"]
      return moduleName1
    }
  
     ,GetModuleName2: function (moduleMarks) {
      let moduleName2
      let middleIndex = Math.floor(moduleMarks.length/2)
      moduleName2  = moduleMarks[middleIndex-1]["module"]
      return moduleName2
    }
  }
  
  