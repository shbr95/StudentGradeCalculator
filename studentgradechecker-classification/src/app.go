package main

import (
	"encoding/json"
	"net/http"

	functions "./functions"
)

func apiRequest(w http.ResponseWriter, r *http.Request) {

	input_text := r.URL.Query().Get("input_text")

	average := functions.GetAverage(input_text)

	classification := ""
	classification = functions.GetClassification(average)
	data := map[string]interface{}{
		"error":  false,
		"string": input_text,
		"answer": classification,
	}

	json.NewEncoder(w).Encode(data)

}

func main() {
	http.HandleFunc("/", apiRequest)
	http.ListenAndServe(":80", nil)

}
