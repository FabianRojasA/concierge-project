package com.jetnews.concierge.api.request

import com.google.gson.annotations.SerializedName
data class LoginRequest (

    @SerializedName("email")
    var email: String,

    @SerializedName("password")
    var password: String

)