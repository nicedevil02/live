package ir.talalive.tv

import android.util.Log
import org.json.JSONArray
import org.json.JSONObject

data class PriceRow(
    val symbol: String,
    val title: String,
    val price: String,
    val unit: String,
    val changeDirection: Int,   // -1 (down), 0 (flat), +1 (up)
    val changeText: String?,
    val isStale: Boolean
)

data class ProductItem(
    val id: String,
    val title: String,
    val weightGram: String?,
    val finalPrice: String?,
    val laborFee: String?,
    val imageUrls: List<String>
)

data class BoardModel(
    val username: String,
    val shopName: String,
    val phone: String,
    val themeMode: String,
    val sliderIntervalSec: Int,
    val rows: List<PriceRow>,
    val products: List<ProductItem>,
    val updatedAtText: String,
    val dataAgeSeconds: Int,
    val isStale: Boolean,
    val refreshIntervalSeconds: Int,
    val rawJson: String
) {
    companion object {
        private const val TAG = "TalaTV.BoardModel"

        fun parse(raw: String): BoardModel? {
            if (raw.isBlank()) return null

            return try {
                val root = JSONObject(raw)

                val username = root.optString("username", "")
                val updatedAt = root.optString("updatedAt", "")
                val dataAgeSeconds = root.optInt("dataAgeSeconds", 0)
                val isStale = root.optBoolean("isStale", false)
                val refreshSec = root.optInt("refreshIntervalSeconds", 60).coerceIn(5, 300)

                val settingsObj = root.optJSONObject("settings")
                val shopName = settingsObj?.optString("shop_name", "گالری طلا")?.ifBlank { "گالری طلا" } ?: "گالری طلا"
                val phone = settingsObj?.optString("phone", "") ?: ""
                val themeMode = settingsObj?.optString("theme_mode", "light-modern") ?: "light-modern"
                val sliderInterval = settingsObj?.optInt("slider_interval_sec", 8)?.coerceIn(3, 60) ?: 8

                // 1. Parse priceFeed map: symbol -> PriceFeedItem
                val priceFeedMap = LinkedHashMap<String, RawPrice>()
                val feedArr = root.optJSONArray("priceFeed") ?: JSONArray()
                for (i in 0 until feedArr.length()) {
                    val pObj = feedArr.optJSONObject(i) ?: continue
                    val symbol = pObj.optString("symbol", "").trim()
                    if (symbol.isEmpty()) continue

                    val label = pObj.optString("label", symbol)
                    val rawVal = pObj.opt("value")
                    val valueStr = cleanNumericValue(rawVal)
                    val unit = pObj.optString("unit", "تومان")
                    val dirStr = pObj.optString("direction", "flat").lowercase()
                    val dirInt = when (dirStr) {
                        "up" -> 1
                        "down" -> -1
                        else -> 0
                    }
                    val chgPct = pObj.optString("change_percent", "").trim()
                    val chgText = if (chgPct.isNotEmpty() && chgPct != "0" && chgPct != "0.00") "$chgPct٪" else null
                    val itemStale = pObj.optBoolean("is_stale", false)

                    priceFeedMap[symbol] = RawPrice(symbol, label, valueStr, unit, dirInt, chgText, itemStale)
                }

                // 2. Parse displayItems if present and join with priceFeed
                val rows = ArrayList<PriceRow>()
                val displayItemsArr = root.optJSONArray("displayItems")

                if (displayItemsArr != null && displayItemsArr.length() > 0) {
                    val itemsList = ArrayList<DisplayItemEntry>()
                    for (i in 0 until displayItemsArr.length()) {
                        val dObj = displayItemsArr.optJSONObject(i) ?: continue
                        val key = dObj.optString("key", "").trim()
                        if (key.isEmpty()) continue
                        val enabled = dObj.optBoolean("enabled", true)
                        if (!enabled) continue
                        val label = dObj.optString("label", "").trim()
                        val order = dObj.optInt("order", i)
                        itemsList.add(DisplayItemEntry(key, label, order))
                    }
                    itemsList.sortBy { it.order }

                    for (entry in itemsList) {
                        val price = priceFeedMap[entry.key]
                        if (price != null) {
                            val title = entry.customLabel.ifBlank { price.defaultLabel }
                            rows.add(
                                PriceRow(
                                    symbol = price.symbol,
                                    title = title,
                                    price = price.value,
                                    unit = price.unit,
                                    changeDirection = price.changeDirection,
                                    changeText = price.changeText,
                                    isStale = price.isStale
                                )
                            )
                        }
                    }
                } else {
                    // Fallback: use priceFeed directly in order
                    for ((_, price) in priceFeedMap) {
                        rows.add(
                            PriceRow(
                                symbol = price.symbol,
                                title = price.defaultLabel,
                                price = price.value,
                                unit = price.unit,
                                changeDirection = price.changeDirection,
                                changeText = price.changeText,
                                isStale = price.isStale
                            )
                        )
                    }
                }

                // 3. Parse products
                val products = ArrayList<ProductItem>()
                val prodArr = root.optJSONArray("products")
                if (prodArr != null) {
                    for (i in 0 until prodArr.length()) {
                        val pObj = prodArr.optJSONObject(i) ?: continue
                        val pId = pObj.optString("id", "")
                        val pTitle = pObj.optString("title", "")
                        val isVisible = pObj.opt("is_visible")
                        val visible = isVisible == true || isVisible == "1" || isVisible == 1
                        if (!visible) continue

                        val imgList = ArrayList<String>()
                        val imgArr = pObj.optJSONArray("images")
                        if (imgArr != null) {
                            for (j in 0 until imgArr.length()) {
                                val iObj = imgArr.optJSONObject(j) ?: continue
                                val u = iObj.optString("url", "").trim()
                                if (u.isNotEmpty()) imgList.add(u)
                            }
                        }
                        if (imgList.isNotEmpty()) {
                            val pWeight = pObj.optString("weight_gram", "").trim().ifEmpty { null }
                            val pFinal = cleanNumericValue(pObj.opt("final_price")).let { if (it == "0") null else it }
                            val pLabor = pObj.optString("labor_fee", "").trim().ifEmpty { null }
                            products.add(ProductItem(pId, pTitle, pWeight, pFinal, pLabor, imgList))
                        }
                    }
                }

                BoardModel(
                    username = username,
                    shopName = shopName,
                    phone = phone,
                    themeMode = themeMode,
                    sliderIntervalSec = sliderInterval,
                    rows = rows,
                    products = products,
                    updatedAtText = updatedAt,
                    dataAgeSeconds = dataAgeSeconds,
                    isStale = isStale,
                    refreshIntervalSeconds = refreshSec,
                    rawJson = raw
                )
            } catch (t: Throwable) {
                Log.e(TAG, "Failed to parse BoardModel", t)
                null
            }
        }

        private fun cleanNumericValue(raw: Any?): String {
            if (raw == null) return "0"
            val s = raw.toString().trim()
            if (s.isEmpty()) return "0"

            // If it ends with .00 or .0, drop the trailing zeros for clean integer display
            return if (s.contains(".")) {
                val parts = s.split(".")
                if (parts.size == 2 && (parts[1] == "0" || parts[1] == "00")) {
                    parts[0]
                } else {
                    s
                }
            } else {
                s
            }
        }
    }

    private data class RawPrice(
        val symbol: String,
        val defaultLabel: String,
        val value: String,
        val unit: String,
        val changeDirection: Int,
        val changeText: String?,
        val isStale: Boolean
    )

    private data class DisplayItemEntry(
        val key: String,
        val customLabel: String,
        val order: Int
    )
}
