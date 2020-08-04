package com.jetnews.concierge.api.response

import androidx.annotation.Keep
import com.google.gson.JsonArray

@Keep
class VisitResponse {

    var message: String? = null
    var visits: JsonArray? = null

}